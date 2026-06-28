<?php declare(strict_types=1);

/**
 * @return array<string, array<string, string>>
 */
function portalLanguages(): array
{
    return [
        'fr' => ['code' => 'fr', 'name' => 'Français', 'native' => 'Français', 'html_lang' => 'fr-BE', 'locale' => 'fr_BE', 'hreflang' => 'fr-BE'],
        'en' => ['code' => 'en', 'name' => 'English', 'native' => 'English', 'html_lang' => 'en-BE', 'locale' => 'en_BE', 'hreflang' => 'en-BE'],
        'ge' => ['code' => 'ge', 'name' => 'Deutsch', 'native' => 'Deutsch', 'html_lang' => 'de-BE', 'locale' => 'de_BE', 'hreflang' => 'de-BE'],
        'nl' => ['code' => 'nl', 'name' => 'Nederlands', 'native' => 'Nederlands', 'html_lang' => 'nl-BE', 'locale' => 'nl_BE', 'hreflang' => 'nl-BE'],
    ];
}

function defaultPortalLanguage(): string
{
    return 'fr';
}

function normalizePortalLanguage(?string $language): string
{
    $language = strtolower(trim((string) $language));
    if ($language === 'de') {
        return 'ge';
    }

    return array_key_exists($language, portalLanguages()) ? $language : defaultPortalLanguage();
}

function currentLanguage(): string
{
    $language = $_GET['lang'] ?? null;
    if (is_string($language) && $language !== '') {
        return normalizePortalLanguage($language);
    }

    return defaultPortalLanguage();
}

/**
 * @return array<string, string>
 */
function portalLanguageConfig(?string $language = null): array
{
    $code = normalizePortalLanguage($language ?? currentLanguage());
    return portalLanguages()[$code];
}

/**
 * @return array<string, mixed>
 */
function getPortalData(?string $language = null): array
{
    static $cache = [];

    $code = normalizePortalLanguage($language ?? currentLanguage());
    if (isset($cache[$code])) {
        return $cache[$code];
    }

    $path = __DIR__ . '/translations/' . $code . '.php';
    if (!is_file($path)) {
        $path = __DIR__ . '/translations/' . defaultPortalLanguage() . '.php';
        $code = defaultPortalLanguage();
    }

    $data = require $path;
    if (!is_array($data)) {
        throw new RuntimeException('Invalid portal translation file: ' . $path);
    }

    $data['language'] = portalLanguageConfig($code);
    $data['ui'] = portalUiTranslations($code);

    return $cache[$code] = $data;
}

/**
 * @return array<string, mixed>
 */
function portalUiTranslations(?string $language = null): array
{
    static $cache = [];

    $code = normalizePortalLanguage($language ?? currentLanguage());
    if (isset($cache[$code])) {
        return $cache[$code];
    }

    $path = __DIR__ . '/ui-translations/' . $code . '.php';
    if (!is_file($path)) {
        $path = __DIR__ . '/ui-translations/' . defaultPortalLanguage() . '.php';
        $code = defaultPortalLanguage();
    }

    $translations = require $path;
    if (!is_array($translations)) {
        throw new RuntimeException('Invalid portal UI translation file: ' . $path);
    }

    return $cache[$code] = $translations;
}

/**
 * @param array<string, scalar|null> $replace
 */
function t(string $key, array $replace = []): string
{
    $translations = portalUiTranslations(currentLanguage());
    $value = $translations[$key] ?? $key;

    foreach ($replace as $replaceKey => $replaceValue) {
        $value = str_replace('{' . $replaceKey . '}', (string) $replaceValue, $value);
    }

    return $value;
}

function localizedUrl(array $params = [], ?string $language = null): string
{
    $query = ['lang' => normalizePortalLanguage($language ?? currentLanguage())];
    foreach ($params as $key => $value) {
        if ($value === null || $value === '') {
            continue;
        }
        $query[(string) $key] = (string) $value;
    }

    return '/?' . http_build_query($query, '', '&', PHP_QUERY_RFC3986);
}

function languageSwitchUrl(string $language): string
{
    $params = ['page' => currentPage()];
    foreach (['resource', 'dossier', 'chapitre', 'term', 'q'] as $key) {
        if (isset($_GET[$key]) && is_string($_GET[$key]) && $_GET[$key] !== '') {
            $params[$key] = $_GET[$key];
        }
    }

    return localizedUrl($params, $language);
}
