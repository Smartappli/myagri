<?php

declare(strict_types=1);

require __DIR__ . '/../includes/data.php';
require __DIR__ . '/../includes/functions.php';

function assertTrue(bool $condition, string $message): void
{
    if (!$condition) {
        fwrite(STDERR, "Assertion failed: {$message}\n");
        exit(1);
    }
}

$data = getPortalData();
assertTrue(isset($data['site']['title']), 'site title exists');
assertTrue(count($data['sectors']) >= 3, 'at least 3 sectors');
assertTrue(count($data['provinces']) === 5, 'five walloon provinces listed');

$_GET['page'] = 'filieres';
assertTrue(currentPage() === 'filieres', 'known page accepted');

$_GET['page'] = 'invalid';
assertTrue(currentPage() === 'accueil', 'unknown page falls back to accueil');

assertTrue(e('<script>') === '&lt;script&gt;', 'escaping works');

echo "Smoke tests OK\n";
