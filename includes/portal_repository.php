<?php

declare(strict_types=1);

require_once __DIR__ . '/data.php';

/**
 * Charge les données du portail depuis MySQL (source obligatoire).
 * Les données locales (includes/data.php) sont synchronisées automatiquement
 * dans la base avant lecture.
 *
 * @return array<string, mixed>
 */
function loadPortalData(): array
{
    pushPortalDataToMySql();

    $pdo = createPortalPdo();

    $mysqlData = loadPortalDataFromMySql($pdo);
    if (!is_array($mysqlData)) {
        throw new RuntimeException('Impossible de charger les données MySQL du portail.');
    }

    return $mysqlData;
}

/**
 * Transfère explicitement le contenu local vers la base MySQL.
 *
 * @throws RuntimeException
 */
function pushPortalDataToMySql(): void
{
    $pdo = createPortalPdo();
    ensurePortalStorageExists($pdo);
    syncPortalDataToMySql($pdo);
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
        throw new RuntimeException('Connexion MySQL obligatoire indisponible: ' . $exception->getMessage(), 0, $exception);
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
        throw new RuntimeException('Impossible de préparer la table portal_content: ' . $exception->getMessage(), 0, $exception);
    }
}

/**
 * Synchronise automatiquement les données locales vers la DB.
 *
 * @throws RuntimeException
 */
function syncPortalDataToMySql(PDO $pdo): void
{
    $payload = json_encode(getPortalData(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);

    $sql = <<<SQL
INSERT INTO portal_content (code, payload_json)
VALUES (:code, :payload_json)
ON DUPLICATE KEY UPDATE payload_json = VALUES(payload_json)
SQL;

    try {
        $statement = $pdo->prepare($sql);
        $statement->execute([
            ':code' => 'main',
            ':payload_json' => $payload,
        ]);
    } catch (Throwable $exception) {
        throw new RuntimeException('Impossible de synchroniser les données dans MySQL: ' . $exception->getMessage(), 0, $exception);
    }
}

/**
 * Lit un payload JSON depuis MySQL (obligatoire).
 *
 * @return array<string, mixed>|null
 */
function loadPortalDataFromMySql(PDO $pdo): ?array
{
    $sql = "SELECT payload_json FROM portal_content WHERE code = 'main' LIMIT 1";

    try {
        return fetchPortalPayload($pdo, $sql);
    } catch (PDOException $exception) {
        // Auto-réparation si la table n'existe pas encore.
        $sqlState = $exception->getCode();
        if ($sqlState === '42S02') {
            ensurePortalStorageExists($pdo);
            syncPortalDataToMySql($pdo);
            return fetchPortalPayload($pdo, $sql);
        }

        throw new RuntimeException('Impossible de lire les données MySQL: ' . $exception->getMessage(), 0, $exception);
    } catch (Throwable $exception) {
        throw new RuntimeException('Impossible de lire les données MySQL: ' . $exception->getMessage(), 0, $exception);
    }
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
