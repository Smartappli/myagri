<?php declare(strict_types=1);

require __DIR__ . '/../includes/data.php';
require __DIR__ . '/../includes/functions.php';

$site = getPortalData();
$baseUrl = getenv('SITE_URL') ?: 'https://myagri.be';
$baseUrl = rtrim($baseUrl, '/');
$lastmod = isset($site['site']['updated_at']) && is_string($site['site']['updated_at'])
    ? updatedAtIsoDate($site['site']['updated_at'])
    : date('Y-m-d');

$pages = [
    ['loc' => $baseUrl . '/', 'changefreq' => 'weekly', 'priority' => '1.0'],
    ['loc' => $baseUrl . '/?page=filieres', 'changefreq' => 'monthly', 'priority' => '0.9'],
    ['loc' => $baseUrl . '/?page=faq', 'changefreq' => 'monthly', 'priority' => '0.8'],
    ['loc' => $baseUrl . '/?page=glossaire', 'changefreq' => 'monthly', 'priority' => '0.8'],
    ['loc' => $baseUrl . '/?page=ressources', 'changefreq' => 'weekly', 'priority' => '0.9'],
];

if (isset($site['resources']) && is_array($site['resources'])) {
    foreach ($site['resources'] as $resource) {
        if (!isset($resource['id']) || !is_string($resource['id'])) {
            continue;
        }
        $pages[] = [
            'loc' => $baseUrl . '/?page=ressource&resource=' . rawurlencode($resource['id']),
            'changefreq' => 'monthly',
            'priority' => '0.7',
        ];
    }
}

if (isset($site['glossary']) && is_array($site['glossary'])) {
    foreach ($site['glossary'] as $glossaryTerm) {
        if (!isset($glossaryTerm['term']) || !is_string($glossaryTerm['term'])) {
            continue;
        }
        $slug = glossarySlug($glossaryTerm['term']);
        $pages[] = [
            'loc' => $baseUrl . '/?page=glossaire&term=' . rawurlencode($slug),
            'changefreq' => 'monthly',
            'priority' => '0.6',
        ];
    }
}

$pages[] = ['loc' => $baseUrl . '/llms.txt', 'changefreq' => 'yearly', 'priority' => '0.2'];
$pages[] = ['loc' => $baseUrl . '/llms-full.txt', 'changefreq' => 'yearly', 'priority' => '0.2'];
$pages[] = ['loc' => $baseUrl . '/api.php', 'changefreq' => 'yearly', 'priority' => '0.3'];
$pages[] = ['loc' => $baseUrl . '/api.php?section=site', 'changefreq' => 'yearly', 'priority' => '0.25'];
$pages[] = ['loc' => $baseUrl . '/api.php?section=sectors', 'changefreq' => 'yearly', 'priority' => '0.25'];
$pages[] = ['loc' => $baseUrl . '/api.php?section=faq', 'changefreq' => 'yearly', 'priority' => '0.25'];
$pages[] = ['loc' => $baseUrl . '/api.php?section=glossary', 'changefreq' => 'yearly', 'priority' => '0.25'];
$pages[] = ['loc' => $baseUrl . '/api.php?section=resources', 'changefreq' => 'yearly', 'priority' => '0.25'];

$xml = new DOMDocument('1.0', 'UTF-8');
$xml->formatOutput = true;
$urlset = $xml->createElement('urlset');
$urlset->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
$xml->appendChild($urlset);

foreach ($pages as $page) {
    $url = $xml->createElement('url');
    $urlset->appendChild($url);

    $url->appendChild($xml->createElement('loc', htmlspecialchars($page['loc'], ENT_XML1)));
    $url->appendChild($xml->createElement('lastmod', htmlspecialchars($lastmod, ENT_XML1)));
    $url->appendChild($xml->createElement('changefreq', htmlspecialchars($page['changefreq'], ENT_XML1)));
    $url->appendChild($xml->createElement('priority', htmlspecialchars($page['priority'], ENT_XML1)));
}

file_put_contents(__DIR__ . '/../sitemap.xml', $xml->saveXML());
echo 'sitemap.xml generated for ' . count($pages) . ' URLs' . PHP_EOL;
