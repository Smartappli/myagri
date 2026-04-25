<?php

declare(strict_types=1);

require __DIR__ . '/../includes/portal_repository.php';

try {
    pushPortalDataToMySql();
    echo "Synchronisation MyAgri -> MySQL réussie.\n";
} catch (Throwable $exception) {
    fwrite(STDERR, "Échec de synchronisation MySQL: " . $exception->getMessage() . "\n");
    exit(1);
}
