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

/**
 * @return list<string>
 */
function activeInterfaceFiles(): array
{
    $files = [
        __DIR__ . '/../index.php',
        __DIR__ . '/../api.php',
        __DIR__ . '/../manifest.php',
        __DIR__ . '/../includes/functions.php',
    ];

    foreach ([__DIR__ . '/../includes/partials/*.php', __DIR__ . '/../includes/views/page-*.php'] as $pattern) {
        $matches = glob($pattern);
        if (!is_array($matches)) {
            continue;
        }
        foreach ($matches as $match) {
            $files[] = $match;
        }
    }

    return array_values(array_unique($files));
}

/**
 * @param list<string> $files
 * @return array<string, list<string>>
 */
function collectInterfaceTranslationKeys(array $files): array
{
    $keys = [];
    foreach ($files as $file) {
        $contents = (string) file_get_contents($file);
        if ($contents === '') {
            continue;
        }

        if (preg_match_all("/\bt\('([^']+)'/", $contents, $matches) !== false) {
            foreach ($matches[1] as $key) {
                $keys[$key][] = $file;
            }
        }
    }

    ksort($keys);

    return $keys;
}

/**
 * @return array<string, scalar|null>
 */
function flattenTranslationLeaves(array $value, string $prefix = ''): array
{
    $result = [];
    foreach ($value as $key => $child) {
        $path = $prefix === '' ? (string) $key : $prefix . '.' . $key;
        if (is_array($child)) {
            $result += flattenTranslationLeaves($child, $path);
            continue;
        }

        if (is_scalar($child) || $child === null) {
            $result[$path] = $child;
        }
    }

    return $result;
}

function assertUtf8CleanFile(string $path): void
{
    $contents = (string) file_get_contents($path);
    assertTrue(preg_match('//u', $contents) === 1, "file is valid UTF-8: {$path}");
    assertTrue(preg_match('/(?:Â|Ã|â€™|â€œ|â€|�)/u', $contents) !== 1, "file has no mojibake markers: {$path}");
}

$data = getPortalData('fr');
assertTrue(isset($data['site']['title']), 'site title exists');
assertTrue(count($data['sectors']) >= 3, 'at least 3 sectors');
assertTrue(count($data['provinces']) === 5, 'five walloon provinces listed');
assertTrue(count($data['glossary']) >= 80, 'expanded glossary has at least 80 terms');
assertTrue(isset($data['dossiers']) && is_array($data['dossiers']) && count($data['dossiers']) >= 3, 'citizen dossiers exist');
foreach ($data['dossiers'] as $dossier) {
    assertTrue(is_array($dossier), 'dossier is an array');
    assertTrue(count($dossier['learning_objectives'] ?? []) >= 4, 'dossier has learning objectives');
    assertTrue(count($dossier['pedagogical_use'] ?? []) >= 4, 'dossier has pedagogical use guidance');
    assertTrue(count($dossier['activity_kit'] ?? []) >= 4, 'dossier has activity kit');
    assertTrue(count($dossier['vocabulary'] ?? []) >= 8, 'dossier has linked vocabulary');
    foreach (($dossier['chapters'] ?? []) as $chapter) {
        assertTrue(is_array($chapter), 'dossier chapter is an array');
        assertTrue(count($chapter['pedagogical_sequence'] ?? []) >= 4, 'chapter has pedagogical sequence');
        assertTrue(isset($chapter['workshop']) && is_array($chapter['workshop']), 'chapter has guided workshop');
        assertTrue(count($chapter['discussion_questions'] ?? []) >= 3, 'chapter has discussion questions');
        assertTrue(count($chapter['teacher_notes'] ?? []) >= 3, 'chapter has teacher notes');
    }
}

$_GET['page'] = 'filieres';
assertTrue(currentPage() === 'filieres', 'known page accepted');

$_GET['page'] = 'faq';
assertTrue(currentPage() === 'faq', 'faq page accepted');

$_GET['page'] = 'glossaire';
assertTrue(currentPage() === 'glossaire', 'glossary page accepted');

$_GET['page'] = 'dossiers';
assertTrue(currentPage() === 'dossiers', 'dossiers page accepted');

$_GET['page'] = 'invalid';
assertTrue(currentPage() === 'accueil', 'unknown page falls back to accueil');

assertTrue(e('<script>') === '&lt;script&gt;', 'escaping works');

$structuredData = pageStructuredData('ressources', $data['site'], $data['sectors'], $data['resources'], $data['faq'], $data['glossary']);
assertTrue(($structuredData['@context'] ?? null) === 'https://schema.org', 'structured data context exists');
assertTrue(is_array($structuredData['@graph'] ?? null), 'structured data graph exists');
assertTrue(pageKeywordList('agriculture, wallonie, agro') === ['agriculture', 'wallonie', 'agro'], 'keyword parser works');
assertTrue(is_file(__DIR__ . '/../assets/css/tailwind-local.css'), 'local Tailwind utility CSS exists');
assertTrue(is_file(__DIR__ . '/../assets/img/logo-myagri.svg'), 'MyAgri logo SVG exists');
$headMarkup = (string) file_get_contents(__DIR__ . '/../includes/partials/head.php');
$tailwindCdn = 'cdn.' . 'tailwindcss.com';
assertTrue(str_contains($headMarkup, 'assets/css/tailwind-local.css'), 'head references local Tailwind CSS');
assertTrue(!str_contains($headMarkup, $tailwindCdn), 'head does not reference Tailwind CDN');
assertTrue(str_contains($headMarkup, 'logo-myagri.svg'), 'head references MyAgri logo');
assertTrue(str_contains($headMarkup, 'manifest.php?lang='), 'head references language-aware PWA manifest');

$manifestPath = __DIR__ . '/../manifest.json';
assertTrue(is_file($manifestPath), 'PWA manifest exists');
$manifest = json_decode((string) file_get_contents($manifestPath), true);
assertTrue(is_array($manifest), 'PWA manifest is valid JSON');
assertTrue(($manifest['short_name'] ?? null) === 'MyAgri', 'PWA short name exists');
assertTrue(isset($manifest['icons']) && is_array($manifest['icons']) && count($manifest['icons']) >= 3, 'PWA icons are declared');
foreach (['fr' => 'fr-BE', 'en' => 'en-BE', 'ge' => 'de-BE', 'nl' => 'nl-BE'] as $language => $htmlLanguage) {
    $_GET['lang'] = $language;
    ob_start();
    require __DIR__ . '/../manifest.php';
    $manifestJson = (string) ob_get_clean();
    $localizedManifest = json_decode($manifestJson, true);
    assertTrue(is_array($localizedManifest), "localized PWA manifest is valid JSON for {$language}");
    assertTrue(($localizedManifest['lang'] ?? null) === $htmlLanguage, "localized PWA manifest lang matches {$language}");
    assertTrue(isset($localizedManifest['name'], $localizedManifest['description']) && is_string($localizedManifest['name']) && is_string($localizedManifest['description']), "localized PWA manifest has text for {$language}");
    assertTrue(isset($localizedManifest['shortcuts']) && is_array($localizedManifest['shortcuts']) && count($localizedManifest['shortcuts']) === 4, "localized PWA manifest shortcuts exist for {$language}");
}
$_GET['lang'] = 'fr';
assertTrue(is_file(__DIR__ . '/../sw.js'), 'service worker exists');
assertTrue(is_file(__DIR__ . '/../offline.html'), 'offline page exists');
assertTrue(is_file(__DIR__ . '/../assets/img/pwa-icon-192.png'), '192px PWA icon exists');
assertTrue(is_file(__DIR__ . '/../assets/img/pwa-icon-512.png'), '512px PWA icon exists');
assertTrue(is_file(__DIR__ . '/../assets/img/pwa-maskable-512.png'), 'maskable PWA icon exists');
assertTrue(is_file(__DIR__ . '/../assets/img/dossier-eau-sols.png'), 'water and soil dossier illustration exists');
assertTrue(is_file(__DIR__ . '/../assets/img/dossier-circuits-courts.png'), 'short circuits dossier illustration exists');
assertTrue(is_file(__DIR__ . '/../assets/img/dossier-climat-biodiversite.png'), 'climate and biodiversity dossier illustration exists');

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

foreach (['fr', 'en', 'ge', 'nl'] as $language) {
    $translatedData = getPortalData($language);
    assertTrue(($translatedData['language']['code'] ?? null) === $language, "language {$language} loads");
    assertTrue(isset($translatedData['site']['title']), "site title exists for {$language}");
}

$translationLeaves = [];
foreach (['fr', 'en', 'ge', 'nl'] as $language) {
    $translationPath = __DIR__ . "/../includes/translations/{$language}.php";
    assertUtf8CleanFile($translationPath);
    $translationLeaves[$language] = flattenTranslationLeaves(require $translationPath);
}
$frenchLeafKeys = array_keys($translationLeaves['fr']);
foreach (['en', 'ge', 'nl'] as $language) {
    $missing = array_diff($frenchLeafKeys, array_keys($translationLeaves[$language]));
    $extra = array_diff(array_keys($translationLeaves[$language]), $frenchLeafKeys);
    assertTrue($missing === [], "translation file {$language} has no missing leaves");
    assertTrue($extra === [], "translation file {$language} has no extra leaves");
}

$interfaceFiles = activeInterfaceFiles();
$interfaceTranslationKeys = collectInterfaceTranslationKeys($interfaceFiles);
assertTrue($interfaceTranslationKeys !== [], 'interface translation keys are detected');
foreach (['fr', 'en', 'ge', 'nl'] as $language) {
    $uiTranslations = portalUiTranslations($language);
    foreach (array_keys($interfaceTranslationKeys) as $key) {
        assertTrue(array_key_exists($key, $uiTranslations), "interface key {$key} exists for {$language}");
        assertTrue(is_string($uiTranslations[$key]) && trim($uiTranslations[$key]) !== '', "interface key {$key} is not empty for {$language}");
    }
}

$englishUiTranslations = portalUiTranslations('en');
$allowedSameAsEnglish = [
    'fr' => ['nav.dossiers' => true, 'nav.faq' => true, 'geo.locality' => true, 'structured.knows_agriculture' => true],
    'ge' => ['nav.dossiers' => true, 'nav.faq' => true, 'geo.locality' => true, 'footer.sitemap' => true],
    'nl' => ['nav.dossiers' => true, 'nav.faq' => true, 'footer.sitemap' => true, 'glossary.default_term' => true],
];
foreach (['fr', 'ge', 'nl'] as $language) {
    $uiTranslations = portalUiTranslations($language);
    foreach (array_keys($interfaceTranslationKeys) as $key) {
        if (!isset($englishUiTranslations[$key], $uiTranslations[$key])) {
            continue;
        }
        if ($uiTranslations[$key] !== $englishUiTranslations[$key]) {
            continue;
        }

        assertTrue(isset($allowedSameAsEnglish[$language][$key]), "interface key {$key} is not an accidental English fallback for {$language}");
    }
}

$hardCodedGermanFragments = ['Zurück', 'Zielgruppe', 'Kurz gesagt', 'Welche Information', 'Welches Kriterium', 'Welche Grenze'];
foreach ($interfaceFiles as $file) {
    $contents = (string) file_get_contents($file);
    foreach ($hardCodedGermanFragments as $fragment) {
        assertTrue(!str_contains($contents, $fragment), "no hard-coded German fragment {$fragment} in active interface file {$file}");
    }
}

$sharedTextAssets = [
    __DIR__ . '/../assets/img/logo-myagri.svg',
    __DIR__ . '/../assets/img/og-default.svg',
    __DIR__ . '/../manifest.json',
    __DIR__ . '/../offline.html',
    __DIR__ . '/../llms.txt',
    __DIR__ . '/../llms-full.txt',
];
foreach ($sharedTextAssets as $assetPath) {
    assertUtf8CleanFile($assetPath);
}
$logoMarkup = (string) file_get_contents(__DIR__ . '/../assets/img/logo-myagri.svg');
$ogMarkup = (string) file_get_contents(__DIR__ . '/../assets/img/og-default.svg');
foreach (['L\'agriculture wallonne expliquée', 'Landwirtschaft in der Wallonie', 'Waalse landbouw uitgelegd', 'Walloon agriculture explained'] as $monolingualSlogan) {
    assertTrue(!str_contains($logoMarkup, $monolingualSlogan), "logo has no monolingual slogan: {$monolingualSlogan}");
    assertTrue(!str_contains($ogMarkup, $monolingualSlogan), "OG image has no monolingual slogan: {$monolingualSlogan}");
}

assertTrue(glossaryTemplatePath('vente-directe') === null, 'glossary uses translated generic rendering');
assertTrue(resourceTemplatePath('visites-pedagogiques') === null, 'resources use translated generic rendering');

try {
    $loadedData = loadPortalData();
    assertTrue(isset($loadedData['site']['title']), 'repository loader returns site title');
} catch (Throwable $exception) {
    assertTrue(str_contains($exception->getMessage(), 'MySQL'), 'repository loader raises explicit mysql error');
}

echo "Smoke tests OK\n";
