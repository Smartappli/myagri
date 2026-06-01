<?php

declare(strict_types=1);

require __DIR__ . '/../includes/data.php';
require __DIR__ . '/../includes/portal_repository.php';
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
assertTrue(count($data['glossary']) >= 80, 'expanded glossary has at least 80 terms');

$_GET['page'] = 'filieres';
assertTrue(currentPage() === 'filieres', 'known page accepted');

$_GET['page'] = 'faq';
assertTrue(currentPage() === 'faq', 'faq page accepted');

$_GET['page'] = 'glossaire';
assertTrue(currentPage() === 'glossaire', 'glossary page accepted');

$_GET['page'] = 'invalid';
assertTrue(currentPage() === 'accueil', 'unknown page falls back to accueil');

assertTrue(e('<script>') === '&lt;script&gt;', 'escaping works');

$structuredData = pageStructuredData('ressources', $data['site'], $data['sectors'], $data['resources'], $data['faq'], $data['glossary']);
assertTrue(($structuredData['@context'] ?? null) === 'https://schema.org', 'structured data context exists');
assertTrue(is_array($structuredData['@graph'] ?? null), 'structured data graph exists');
assertTrue(pageKeywordList('agriculture, wallonie, agro') === ['agriculture', 'wallonie', 'agro'], 'keyword parser works');

$sampleResource = $data['resources'][0] ?? null;
if (is_array($sampleResource)) {
    $resourcePairs = resourceFaqPairs($sampleResource);
    assertTrue(is_array($resourcePairs), 'resource FAQ pairs computed');
    assertTrue($resourcePairs !== [], 'resource FAQ pairs are not empty');
}

$sampleTerm = $data['glossary'][0] ?? null;
if (is_array($sampleTerm)) {
    $termPairs = glossaryTermFaqPairs($sampleTerm);
    assertTrue(is_array($termPairs), 'glossary FAQ pairs computed');
    assertTrue($termPairs !== [], 'glossary FAQ pairs are not empty');
}

assertTrue(glossaryTemplatePath('vente-directe') !== null, 'generic glossary term template fallback exists');

try {
    $loadedData = loadPortalData();
    assertTrue(isset($loadedData['site']['title']), 'repository loader returns site title');
} catch (Throwable $exception) {
    assertTrue(str_contains($exception->getMessage(), 'MySQL'), 'repository loader raises explicit mysql error');
}

echo "Smoke tests OK\n";
