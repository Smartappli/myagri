<?php

declare(strict_types=1);

$python = PHP_OS_FAMILY === 'Windows' ? 'py' : 'python';
$script = __DIR__ . '/../tests/selenium/test_site.py';
$exitCode = 1;

passthru($python . ' ' . escapeshellarg($script), $exitCode);
exit($exitCode);
