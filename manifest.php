<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/data.php';

$language = currentLanguage();
$languageConfig = portalLanguageConfig($language);
$data = getPortalData($language);
$site = is_array($data['site'] ?? null) ? $data['site'] : [];
$siteTitle = isset($site['title']) && is_string($site['title']) ? $site['title'] : 'MyAgri';
$siteDescription = isset($site['subtitle']) && is_string($site['subtitle']) ? $site['subtitle'] : 'MyAgri';
$homeUrl = '/?lang=' . rawurlencode($language) . '&page=accueil';

$shortcutIcon = [
    'src' => '/assets/img/pwa-icon-192.png',
    'sizes' => '192x192',
];

$manifest = [
    'name' => $siteTitle,
    'short_name' => 'MyAgri',
    'description' => $siteDescription,
    'lang' => $languageConfig['html_lang'],
    'dir' => 'ltr',
    'id' => $homeUrl,
    'start_url' => $homeUrl,
    'scope' => '/',
    'display' => 'standalone',
    'background_color' => '#f6f7f2',
    'theme_color' => '#1f7a45',
    'orientation' => 'any',
    'categories' => ['education', 'food', 'reference'],
    'icons' => [
        [
            'src' => '/assets/img/pwa-icon-192.png',
            'sizes' => '192x192',
            'type' => 'image/png',
            'purpose' => 'any',
        ],
        [
            'src' => '/assets/img/pwa-icon-512.png',
            'sizes' => '512x512',
            'type' => 'image/png',
            'purpose' => 'any',
        ],
        [
            'src' => '/assets/img/pwa-maskable-512.png',
            'sizes' => '512x512',
            'type' => 'image/png',
            'purpose' => 'maskable',
        ],
    ],
    'shortcuts' => [
        [
            'name' => t('sectors.title'),
            'short_name' => t('nav.sectors'),
            'description' => t('sectors.intro'),
            'url' => '/?lang=' . rawurlencode($language) . '&page=filieres',
            'icons' => [$shortcutIcon],
        ],
        [
            'name' => t('resources.title'),
            'short_name' => t('nav.resources'),
            'description' => t('resources.intro'),
            'url' => '/?lang=' . rawurlencode($language) . '&page=ressources',
            'icons' => [$shortcutIcon],
        ],
        [
            'name' => t('dossiers.title'),
            'short_name' => t('nav.dossiers'),
            'description' => t('dossiers.intro'),
            'url' => '/?lang=' . rawurlencode($language) . '&page=dossiers',
            'icons' => [$shortcutIcon],
        ],
        [
            'name' => t('glossary.title'),
            'short_name' => t('nav.glossary'),
            'description' => t('glossary.intro', ['count' => '80+']),
            'url' => '/?lang=' . rawurlencode($language) . '&page=glossaire',
            'icons' => [$shortcutIcon],
        ],
    ],
];

if (!headers_sent()) {
    header('Content-Type: application/manifest+json; charset=UTF-8');
}
echo json_encode($manifest, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR);
