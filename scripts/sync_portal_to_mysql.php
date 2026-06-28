<?php

declare(strict_types=1);

require __DIR__ . '/../includes/portal_repository.php';

$requestedLanguage = isset($argv[1]) && is_string($argv[1]) ? $argv[1] : defaultPortalLanguage();
$_GET['lang'] = normalizePortalLanguage($requestedLanguage);

try {
    pushPortalDataToMySql();
    echo t('repository.sync_success') . "\n";
} catch (Throwable $exception) {
    fwrite(STDERR, t('repository.sync_failed') . ': ' . $exception->getMessage() . "\n");
    exit(1);
}
