<?php

declare(strict_types=1);

$root = dirname(__DIR__);
$sitemapPath = $root . '/sitemap.xml';
$builderPath = $root . '/scripts/build_sitemap.php';
$original = is_file($sitemapPath) ? (string) file_get_contents($sitemapPath) : '';

$command = escapeshellarg(PHP_BINARY) . ' ' . escapeshellarg($builderPath);
$output = [];
$exitCode = 1;
exec($command, $output, $exitCode);

if ($exitCode !== 0) {
    fwrite(STDERR, implode(PHP_EOL, $output) . PHP_EOL);
    exit($exitCode);
}

$generated = is_file($sitemapPath) ? (string) file_get_contents($sitemapPath) : '';
if ($generated !== $original) {
    file_put_contents($sitemapPath, $original);
    fwrite(STDERR, "sitemap.xml is not up to date. Run composer build:sitemap and commit the result." . PHP_EOL);
    exit(1);
}

echo implode(PHP_EOL, $output) . PHP_EOL;
echo "sitemap.xml is up to date" . PHP_EOL;
