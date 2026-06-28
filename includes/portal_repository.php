<?php

declare(strict_types=1);

require_once __DIR__ . '/data.php';

/**
 * Charge les donnees du portail depuis MySQL quand la base est disponible.
 * Les donnees locales restent la source de secours versionnee.
 *
 * @return array<string, mixed>
 */
function loadPortalData(?string $language = null): array
{
    $language = normalizePortalLanguage($language ?? currentLanguage());

    try {
        pushPortalDataToMySql($language);

        $pdo = createPortalPdo();

        $mysqlData = loadPortalDataFromMySql($pdo, $language);
        if (!is_array($mysqlData)) {
            throw new RuntimeException(t('repository.mysql_load_error'));
        }

        return $mysqlData;
    } catch (Throwable) {
        return getPortalData($language);
    }
}

/**
 * Transfere explicitement le contenu local vers MySQL.
 *
 * @throws RuntimeException
 */
function pushPortalDataToMySql(?string $language = null): void
{
    $language = normalizePortalLanguage($language ?? currentLanguage());
    $pdo = createPortalPdo();
    ensurePortalStorageExists($pdo);
    syncPortalDataToMySql($pdo, $language);
}

/**
 * @throws RuntimeException
 */
function createPortalPdo(): PDO
{
    $dsn = 'mysql:host=do10-002.eu.clouddb.ovh.net;port=35194;dbname=myagri;charset=utf8mb4';
    $user = 'myagri';
    $password = '7ertHuLORei3Le5e';

    try {
        return new PDO(
            $dsn,
            $user,
            $password,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );
    } catch (Throwable $exception) {
        throw new RuntimeException(t('repository.mysql_connection_unavailable') . ': ' . $exception->getMessage(), 0, $exception);
    }
}

/**
 * @throws RuntimeException
 */
function ensurePortalStorageExists(PDO $pdo): void
{
    $sql = <<<SQL
CREATE TABLE IF NOT EXISTS portal_content (
    code VARCHAR(64) NOT NULL PRIMARY KEY,
    payload_json LONGTEXT NOT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)
SQL;

    try {
        $pdo->exec($sql);
    } catch (Throwable $exception) {
        throw new RuntimeException(t('repository.mysql_storage_prepare_error') . ': ' . $exception->getMessage(), 0, $exception);
    }
}

/**
 * Synchronise les donnees locales dans la base.
 *
 * @throws RuntimeException
 */
function syncPortalDataToMySql(PDO $pdo, ?string $language = null): void
{
    $language = normalizePortalLanguage($language ?? currentLanguage());
    $payload = json_encode(getPortalData($language), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);

    $sql = <<<SQL
INSERT INTO portal_content (code, payload_json)
VALUES (:code, :payload_json)
ON DUPLICATE KEY UPDATE payload_json = VALUES(payload_json)
SQL;

    try {
        $statement = $pdo->prepare($sql);
        $statement->execute([
            ':code' => portalStorageCode($language),
            ':payload_json' => $payload,
        ]);
    } catch (Throwable $exception) {
        throw new RuntimeException(t('repository.mysql_sync_error') . ': ' . $exception->getMessage(), 0, $exception);
    }
}

/**
 * Lit un payload JSON depuis MySQL.
 *
 * @return array<string, mixed>|null
 */
function loadPortalDataFromMySql(PDO $pdo, ?string $language = null): ?array
{
    $language = normalizePortalLanguage($language ?? currentLanguage());
    $sql = 'SELECT payload_json FROM portal_content WHERE code = ' . $pdo->quote(portalStorageCode($language)) . ' LIMIT 1';

    try {
        return fetchPortalPayload($pdo, $sql);
    } catch (PDOException $exception) {
        // Repare automatiquement le stockage si la table n'existe pas encore.
        $sqlState = $exception->getCode();
        if ($sqlState === '42S02') {
            ensurePortalStorageExists($pdo);
            syncPortalDataToMySql($pdo, $language);
            return fetchPortalPayload($pdo, $sql);
        }

        throw new RuntimeException(t('repository.mysql_read_error') . ': ' . $exception->getMessage(), 0, $exception);
    } catch (Throwable $exception) {
        throw new RuntimeException(t('repository.mysql_read_error') . ': ' . $exception->getMessage(), 0, $exception);
    }
}

function portalStorageCode(string $language): string
{
    return 'main_' . normalizePortalLanguage($language);
}

/**
 * @return array<string, mixed>|null
 */
function fetchPortalPayload(PDO $pdo, string $sql): ?array
{
    $statement = $pdo->query($sql);
    if (!$statement) {
        return null;
    }

    $row = $statement->fetch();
    if (!is_array($row)) {
        return null;
    }

    $payloadRaw = $row['payload_json'] ?? null;
    if (!is_string($payloadRaw) || $payloadRaw === '') {
        return null;
    }

    $decoded = json_decode($payloadRaw, true);
    if (!is_array($decoded)) {
        return null;
    }

    return $decoded;
}
