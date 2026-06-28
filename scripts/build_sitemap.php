<?php declare(strict_types=1);

require __DIR__ . '/../includes/data.php';
require __DIR__ . '/../includes/functions.php';

$baseUrl = getenv('SITE_URL') ?: 'https://myagri.be';
$baseUrl = rtrim($baseUrl, '/');
$pages = [];

foreach (array_keys(portalLanguages()) as $language) {
    $_GET['lang'] = $language;
    $site = getPortalData($language);
    $lastmod = isset($site['site']['updated_at']) && is_string($site['site']['updated_at'])
        ? updatedAtIsoDate($site['site']['updated_at'])
        : date('Y-m-d');

    $add = static function (string $loc, string $changefreq, string $priority) use (&$pages, $baseUrl, $lastmod): void {
        $pages[] = [
            'loc' => $baseUrl . $loc,
            'lastmod' => $lastmod,
            'changefreq' => $changefreq,
            'priority' => $priority,
        ];
    };

    $add(canonicalPath('accueil', '', '', '', '', $language), 'weekly', '1.0');
    $add(canonicalPath('filieres', '', '', '', '', $language), 'monthly', '0.9');
    $add(canonicalPath('faq', '', '', '', '', $language), 'monthly', '0.8');
    $add(canonicalPath('glossaire', '', '', '', '', $language), 'monthly', '0.8');
    $add(canonicalPath('ressources', '', '', '', '', $language), 'weekly', '0.9');
    $add(canonicalPath('dossiers', '', '', '', '', $language), 'monthly', '0.85');

    if (isset($site['resources']) && is_array($site['resources'])) {
        foreach ($site['resources'] as $resource) {
            if (!isset($resource['id']) || !is_string($resource['id'])) {
                continue;
            }
            $add(canonicalPath('ressource', $resource['id'], '', '', '', $language), 'monthly', '0.7');
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

                $add(canonicalPath('dossier', '', '', $dossier['id'], $chapter['id'], $language), 'monthly', '0.75');
            }
        }
    }

    if (isset($site['glossary']) && is_array($site['glossary'])) {
        foreach ($site['glossary'] as $glossaryTerm) {
            if (!isset($glossaryTerm['term']) || !is_string($glossaryTerm['term'])) {
                continue;
            }
            $add(canonicalPath('glossaire', '', glossaryEntrySlug($glossaryTerm), '', '', $language), 'monthly', '0.6');
        }
    }

    $add('/api.php?lang=' . rawurlencode($language), 'yearly', '0.3');
    foreach (['site', 'sectors', 'faq', 'glossary', 'resources'] as $section) {
        $add('/api.php?lang=' . rawurlencode($language) . '&section=' . rawurlencode($section), 'yearly', '0.25');
    }
}

$pages[] = ['loc' => $baseUrl . '/llms.txt', 'lastmod' => date('Y-m-d'), 'changefreq' => 'yearly', 'priority' => '0.2'];
$pages[] = ['loc' => $baseUrl . '/llms-full.txt', 'lastmod' => date('Y-m-d'), 'changefreq' => 'yearly', 'priority' => '0.2'];

$xml = new DOMDocument('1.0', 'UTF-8');
$xml->formatOutput = true;
$urlset = $xml->createElement('urlset');
$urlset->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
$xml->appendChild($urlset);

foreach ($pages as $page) {
    $url = $xml->createElement('url');
    $urlset->appendChild($url);

    $url->appendChild($xml->createElement('loc', htmlspecialchars($page['loc'], ENT_XML1)));
    $url->appendChild($xml->createElement('lastmod', htmlspecialchars($page['lastmod'], ENT_XML1)));
    $url->appendChild($xml->createElement('changefreq', htmlspecialchars($page['changefreq'], ENT_XML1)));
    $url->appendChild($xml->createElement('priority', htmlspecialchars($page['priority'], ENT_XML1)));
}

file_put_contents(__DIR__ . '/../sitemap.xml', $xml->saveXML());
echo 'sitemap.xml generated for ' . count($pages) . ' URLs' . PHP_EOL;
