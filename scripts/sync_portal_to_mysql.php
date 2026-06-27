<?php

declare(strict_types=1);

require __DIR__ . '/../includes/portal_repository.php';

try {
    pushPortalDataToMySql();
    echo "MyAgri -> MySQL-Synchronisierung erfolgreich.\n";
} catch (Throwable $exception) {
    fwrite(STDERR, "MySQL-Synchronisierung fehlgeschlagen: " . $exception->getMessage() . "\n");
    exit(1);
}
