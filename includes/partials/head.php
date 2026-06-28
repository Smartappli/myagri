<?php
$siteGeo = siteGeoConfig($site);
$robotsDirective = ($allowIndex ?? true)
    ? 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1'
    : 'noindex, nofollow, max-snippet:-1, max-video-preview:-1';
$geoCoordinates = $siteGeo['latitude'] . '; ' . $siteGeo['longitude'];
?>
<!DOCTYPE html>
<html lang="<?= e(siteLanguage()) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?></title>
    <meta name="description" content="<?= e($metaDescription) ?>">
    <meta name="keywords" content="<?= e($metaKeywords) ?>">
    <meta name="author" content="MyAgri">
    <meta name="theme-color" content="#1f7a45">
    <meta name="application-name" content="MyAgri">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="MyAgri">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="msapplication-TileColor" content="#1f7a45">
    <meta http-equiv="content-language" content="<?= e(siteLanguage()) ?>">
    <meta name="language" content="<?= e(siteLanguage()) ?>">
    <meta name="geo.region" content="<?= e($siteGeo['region_code']) ?>">
    <meta name="geo.placename" content="<?= e($siteGeo['region']) ?>">
    <meta name="geo.position" content="<?= e($geoCoordinates) ?>">
    <meta name="ICBM" content="<?= e($geoCoordinates) ?>">
    <meta name="geo.country" content="<?= e($siteGeo['country_code']) ?>">
    <meta name="robots" content="<?= e($robotsDirective) ?>">
    <link rel="canonical" href="<?= e($canonicalUrl) ?>">
    <link rel="manifest" href="/manifest.json">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/img/favicon-32.png">
    <link rel="apple-touch-icon" href="/assets/img/apple-touch-icon.png">
    <link rel="sitemap" type="application/xml" href="<?= e(siteBaseUrl() . '/sitemap.xml') ?>">
    <link rel="alternate" type="text/plain" href="<?= e(siteBaseUrl() . '/llms.txt') ?>" title="<?= e(t('head.llms_short_title')) ?>">
    <link rel="alternate" type="text/plain" href="<?= e(siteBaseUrl() . '/llms-full.txt') ?>" title="<?= e(t('head.llms_full_title')) ?>">
    <link rel="alternate" type="application/json" href="<?= e(siteBaseUrl() . '/api.php?lang=' . rawurlencode(currentLanguage())) ?>" title="<?= e(t('head.api_title')) ?>">
    <meta property="og:locale" content="<?= e(siteLocale()) ?>">
    <meta property="og:type" content="<?= ($page === 'ressource' || $page === 'dossier' || ($page === 'glossaire' && is_array($selectedGlossaryTerm ?? null))) ? 'article' : 'website' ?>">
    <meta property="og:title" content="<?= e($pageTitle) ?>">
    <meta property="og:description" content="<?= e($metaDescription) ?>">
    <meta property="og:url" content="<?= e($canonicalUrl) ?>">
    <meta property="og:site_name" content="<?= e($site['title']) ?>">
    <meta property="og:image" content="<?= e($metaImage) ?>">
    <meta property="og:image:alt" content="<?= e(t('head.image_alt')) ?>">
    <meta property="place:location:latitude" content="<?= e($siteGeo['latitude']) ?>">
    <meta property="place:location:longitude" content="<?= e($siteGeo['longitude']) ?>">
    <meta property="place:location:country_name" content="<?= e($siteGeo['country']) ?>">
    <meta property="article:modified_time" content="<?= e(updatedAtIsoDate(isset($site['updated_at']) && is_string($site['updated_at']) ? $site['updated_at'] : '')) ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@MyAgri">
    <meta name="twitter:title" content="<?= e($pageTitle) ?>">
    <meta name="twitter:description" content="<?= e($metaDescription) ?>">
    <meta name="twitter:image" content="<?= e($metaImage) ?>">
    <meta name="twitter:image:alt" content="<?= e(t('head.image_alt')) ?>">
    <?php foreach (portalLanguages() as $alternateCode => $alternateConfig): ?>
        <link rel="alternate" href="<?= e(siteBaseUrl() . canonicalPath($page, $canonicalResource ?? '', $canonicalGlossaryTerm ?? '', $canonicalDossier ?? '', $canonicalChapter ?? '', $alternateCode)) ?>" hreflang="<?= e($alternateConfig['hreflang']) ?>">
    <?php endforeach; ?>
    <link rel="alternate" href="<?= e(siteBaseUrl() . canonicalPath($page, $canonicalResource ?? '', $canonicalGlossaryTerm ?? '', $canonicalDossier ?? '', $canonicalChapter ?? '', defaultPortalLanguage())) ?>" hreflang="x-default">
    <meta property="article:published_time" content="<?= e(updatedAtIsoDate(isset($site['updated_at']) && is_string($site['updated_at']) ? $site['updated_at'] : '')) ?>">
    <link rel="stylesheet" href="assets/css/tailwind-local.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script type="application/ld+json"><?= json_encode($structuredData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR) ?></script>
    <!-- Matomo -->
    <script>
        var _paq = window._paq = window._paq || [];
        /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
        _paq.push(['trackPageView']);
        _paq.push(['enableLinkTracking']);
        (function() {
            var u = "https://stats.smartappli.eu/";
            _paq.push(['setTrackerUrl', u + 'matomo.php']);
            _paq.push(['setSiteId', '5']);
            var d = document, g = d.createElement('script'), s = d.getElementsByTagName('script')[0];
            g.async = true;
            g.src = u + 'matomo.js';
            s.parentNode.insertBefore(g, s);
        })();
    </script>
    <!-- End Matomo Code -->
</head>
<body>
<header class="site-hero relative overflow-hidden">
    <div class="container">
        <div class="header-top">
            <a class="brand-link" href="<?= e(localizedUrl(['page' => 'accueil'])) ?>" aria-label="<?= e(t('head.brand_aria')) ?>">
                <img src="/assets/img/logo-myagri.svg" alt="MyAgri">
            </a>
            <div class="header-actions">
                <nav aria-label="<?= e(t('head.nav_aria')) ?>">
                    <ul class="nav-list shadow-soft">
                        <li><a href="<?= e(localizedUrl(['page' => 'accueil'])) ?>"<?= $page === 'accueil' ? ' aria-current="page"' : '' ?>><?= e(t('nav.home')) ?></a></li>
                        <li><a href="<?= e(localizedUrl(['page' => 'filieres'])) ?>"<?= $page === 'filieres' ? ' aria-current="page"' : '' ?>><?= e(t('nav.sectors')) ?></a></li>
                        <li><a href="<?= e(localizedUrl(['page' => 'ressources'])) ?>"<?= $page === 'ressources' ? ' aria-current="page"' : '' ?>><?= e(t('nav.resources')) ?></a></li>
                        <li><a href="<?= e(localizedUrl(['page' => 'dossiers'])) ?>"<?= in_array($page, ['dossiers', 'dossier'], true) ? ' aria-current="page"' : '' ?>><?= e(t('nav.dossiers')) ?></a></li>
                        <li><a href="<?= e(localizedUrl(['page' => 'faq'])) ?>"<?= $page === 'faq' ? ' aria-current="page"' : '' ?>><?= e(t('nav.faq')) ?></a></li>
                        <li><a href="<?= e(localizedUrl(['page' => 'glossaire'])) ?>"<?= $page === 'glossaire' ? ' aria-current="page"' : '' ?>><?= e(t('nav.glossary')) ?></a></li>
                    </ul>
                </nav>
                <nav class="language-switcher" aria-label="<?= e(t('language.aria')) ?>">
                    <span><?= e(t('language.label')) ?></span>
                    <ul>
                        <?php foreach (portalLanguages() as $languageCode => $languageConfig): ?>
                            <li><a href="<?= e(languageSwitchUrl($languageCode)) ?>"<?= currentLanguage() === $languageCode ? ' aria-current="true"' : '' ?>><?= e(strtoupper($languageCode === 'ge' ? 'de' : $languageCode)) ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
            </div>
        </div>
        <section class="hero" aria-labelledby="hero-title">
            <figure class="hero-visual">
                <img src="assets/img/hero.png" alt="<?= e(t('head.image_alt')) ?>">
                <figcaption class="hero-copy">
                    <h1 id="hero-title"><?= e($site['title']) ?></h1>
                    <p><?= e($site['subtitle']) ?></p>
                    <p class="hero-meta"><?= e(t('hero.updated_prefix')) ?> <?= e($site['updated_at']) ?> &middot; <?= e(t('hero.geo_label')) ?></p>
                </figcaption>
            </figure>
        </section>
    </div>
</header>

<div class="container hero-search-wrap">
    <form method="get" class="search-form hero-search">
        <input type="hidden" name="page" value="<?= e($page) ?>">
        <input type="hidden" name="lang" value="<?= e(currentLanguage()) ?>">
        <label for="global-search" class="meta"><?= e(t('search.label')) ?></label>
        <input id="global-search" class="filter w-full rounded-xl border border-emerald-200 bg-white/95 px-3 py-2" name="q" value="<?= e($search) ?>" placeholder="<?= e(t('search.placeholder')) ?>" type="search">
    </form>
</div>

<main class="container py-8">
