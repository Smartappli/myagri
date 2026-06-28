<?php declare(strict_types=1);

require __DIR__ . '/../includes/data.php';
require __DIR__ . '/../includes/functions.php';

$baseUrl = getenv('SITE_URL') ?: 'https://myagri.be';
$baseUrl = rtrim($baseUrl, '/');
$pages = [];
$defaultSite = getPortalData(defaultPortalLanguage());
$defaultLastmod = isset($defaultSite['site']['updated_at']) && is_string($defaultSite['site']['updated_at'])
    ? updatedAtIsoDate($defaultSite['site']['updated_at'])
    : date('Y-m-d');

/**
 * @return list<array{hreflang:string, href:string}>
 */
function sitemapAlternates(string $baseUrl, string $page, string $resourceId = '', string $glossaryTerm = '', string $dossierId = '', string $chapterId = ''): array
{
    $alternates = [];
    foreach (portalLanguages() as $language => $config) {
        $alternates[] = [
            'hreflang' => $config['hreflang'],
            'href' => $baseUrl . canonicalPath($page, $resourceId, $glossaryTerm, $dossierId, $chapterId, $language),
        ];
    }

    $alternates[] = [
        'hreflang' => 'x-default',
        'href' => $baseUrl . canonicalPath($page, $resourceId, $glossaryTerm, $dossierId, $chapterId, defaultPortalLanguage()),
    ];

    return $alternates;
}

foreach (array_keys(portalLanguages()) as $language) {
    $_GET['lang'] = $language;
    $site = getPortalData($language);
    $lastmod = isset($site['site']['updated_at']) && is_string($site['site']['updated_at'])
        ? updatedAtIsoDate($site['site']['updated_at'])
        : date('Y-m-d');

    $add = static function (string $page, string $changefreq, string $priority, string $resourceId = '', string $glossaryTerm = '', string $dossierId = '', string $chapterId = '') use (&$pages, $baseUrl, $lastmod, $language): void {
        $pages[] = [
            'loc' => $baseUrl . canonicalPath($page, $resourceId, $glossaryTerm, $dossierId, $chapterId, $language),
            'lastmod' => $lastmod,
            'changefreq' => $changefreq,
            'priority' => $priority,
            'alternates' => sitemapAlternates($baseUrl, $page, $resourceId, $glossaryTerm, $dossierId, $chapterId),
        ];
    };
    $addRaw = static function (string $loc, string $changefreq, string $priority) use (&$pages, $baseUrl, $lastmod): void {
        $pages[] = [
            'loc' => $baseUrl . $loc,
            'lastmod' => $lastmod,
            'changefreq' => $changefreq,
            'priority' => $priority,
            'alternates' => [],
        ];
    };

    $add('accueil', 'weekly', '1.0');
    $add('filieres', 'monthly', '0.9');
    $add('faq', 'monthly', '0.8');
    $add('glossaire', 'monthly', '0.8');
    $add('ressources', 'weekly', '0.9');
    $add('dossiers', 'monthly', '0.85');

    if (isset($site['resources']) && is_array($site['resources'])) {
        foreach ($site['resources'] as $resource) {
            if (!isset($resource['id']) || !is_string($resource['id'])) {
                continue;
            }
            $add('ressource', 'monthly', '0.7', $resource['id']);
        }
    }

    if (isset($site['dossiers']) && is_array($site['dossiers'])) {
        foreach ($site['dossiers'] as $dossier) {
            if (!isset($dossier['id']) || !is_string($dossier['id'])) {
                continue;
            }

            $chapters = is_array($dossier['chapters'] ?? null) ? $dossier['chapters'] : [];
            foreach ($chapters as $chapter) {
                if (!isset($chapter['id']) || !is_string($chapter['id'])) {
                    continue;
                }

                $add('dossier', 'monthly', '0.75', '', '', $dossier['id'], $chapter['id']);
            }
        }
    }

    if (isset($site['glossary']) && is_array($site['glossary'])) {
        foreach ($site['glossary'] as $glossaryTerm) {
            if (!isset($glossaryTerm['term']) || !is_string($glossaryTerm['term'])) {
                continue;
            }
            $add('glossaire', 'monthly', '0.6', '', glossaryEntrySlug($glossaryTerm));
        }
    }

    $addRaw('/api.php?lang=' . rawurlencode($language), 'yearly', '0.3');
    foreach (['site', 'sectors', 'faq', 'glossary', 'resources'] as $section) {
        $addRaw('/api.php?lang=' . rawurlencode($language) . '&section=' . rawurlencode($section), 'yearly', '0.25');
    }
}

$pages[] = ['loc' => $baseUrl . '/llms.txt', 'lastmod' => $defaultLastmod, 'changefreq' => 'yearly', 'priority' => '0.2', 'alternates' => []];
$pages[] = ['loc' => $baseUrl . '/llms-full.txt', 'lastmod' => $defaultLastmod, 'changefreq' => 'yearly', 'priority' => '0.2', 'alternates' => []];

$xml = new DOMDocument('1.0', 'UTF-8');
$xml->formatOutput = true;
$urlset = $xml->createElementNS('http://www.sitemaps.org/schemas/sitemap/0.9', 'urlset');
$urlset->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:xhtml', 'http://www.w3.org/1999/xhtml');
$xml->appendChild($urlset);

foreach ($pages as $page) {
    $url = $xml->createElement('url');
    $urlset->appendChild($url);

    foreach (['loc', 'lastmod', 'changefreq', 'priority'] as $field) {
        $node = $xml->createElement($field);
        $node->appendChild($xml->createTextNode($page[$field]));
        $url->appendChild($node);
    }

    foreach ($page['alternates'] as $alternate) {
        $node = $xml->createElementNS('http://www.w3.org/1999/xhtml', 'xhtml:link');
        $node->setAttribute('rel', 'alternate');
        $node->setAttribute('hreflang', $alternate['hreflang']);
        $node->setAttribute('href', $alternate['href']);
        $url->appendChild($node);
    }
}

file_put_contents(__DIR__ . '/../sitemap.xml', $xml->saveXML());
echo 'sitemap.xml generated for ' . count($pages) . ' URLs' . PHP_EOL;
