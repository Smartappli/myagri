<?php

declare(strict_types=1);

/**
 * Charge les données du portail depuis MySQL (source obligatoire).
 *
 * @return array<string, mixed>
 */
function loadPortalData(): array
{
    $mysqlData = loadPortalDataFromMySql();
    if (!is_array($mysqlData)) {
        throw new RuntimeException('Impossible de charger les données MySQL du portail.');
    }

    return $mysqlData;
}

/**
 * Lit un payload JSON depuis MySQL (obligatoire).
 *
 * @return array<string, mixed>|null
 */
function loadPortalDataFromMySql(): ?array
{
    $dsn = 'mysql:host=do10-002.eu.clouddb.ovh.net;port=35194;dbname=myagri;charset=utf8mb4';
    $user = 'myagri';
    $password = '7ertHuLORei3Le5e';
    $sql = "SELECT payload_json FROM portal_content WHERE code = 'main' LIMIT 1";

    try {
        $pdo = new PDO(
            $dsn,
            $user,
            $password,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );

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
    } catch (Throwable $exception) {
        throw new RuntimeException('Connexion MySQL obligatoire indisponible: ' . $exception->getMessage(), 0, $exception);
    }
}
