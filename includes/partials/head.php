<?php
$siteGeo = siteGeoConfig($site);
$robotsDirective = ($allowIndex ?? true)
    ? 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1'
    : 'noindex, nofollow, max-snippet:-1, max-video-preview:-1';
$geoCoordinates = $siteGeo['latitude'] . '; ' . $siteGeo['longitude'];
?>
<!DOCTYPE html>
<html lang="fr-BE">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?></title>
    <meta name="description" content="<?= e($metaDescription) ?>">
    <meta name="keywords" content="<?= e($metaKeywords) ?>">
    <meta name="author" content="MyAgri">
    <meta name="theme-color" content="#1f7a45">
    <meta name="language" content="fr-BE">
    <meta name="geo.region" content="<?= e($siteGeo['region_code']) ?>">
    <meta name="geo.placename" content="<?= e($siteGeo['region']) ?>">
    <meta name="geo.position" content="<?= e($geoCoordinates) ?>">
    <meta name="ICBM" content="<?= e($geoCoordinates) ?>">
    <meta name="geo.country" content="<?= e($siteGeo['country_code']) ?>">
    <meta name="robots" content="<?= e($robotsDirective) ?>">
    <link rel="canonical" href="<?= e($canonicalUrl) ?>">
    <link rel="sitemap" type="application/xml" href="<?= e(siteBaseUrl() . '/sitemap.xml') ?>">
    <link rel="alternate" type="text/plain" href="<?= e(siteBaseUrl() . '/llms.txt') ?>" title="Résumé MyAgri pour moteurs génératifs">
    <link rel="alternate" type="text/plain" href="<?= e(siteBaseUrl() . '/llms-full.txt') ?>" title="Corpus MyAgri pour moteurs génératifs">
    <link rel="alternate" type="application/json" href="<?= e(siteBaseUrl() . '/api.php') ?>" title="Données structurées MyAgri">
    <meta property="og:locale" content="fr_BE">
    <meta property="og:type" content="<?= ($page === 'ressource' || $page === 'glossaire') ? 'article' : 'website' ?>">
    <meta property="og:title" content="<?= e($pageTitle) ?>">
    <meta property="og:description" content="<?= e($metaDescription) ?>">
    <meta property="og:url" content="<?= e($canonicalUrl) ?>">
    <meta property="og:site_name" content="<?= e($site['title']) ?>">
    <meta property="og:image" content="<?= e($metaImage) ?>">
    <meta property="og:image:alt" content="Paysage agricole wallon illustrant le portail citoyen MyAgri">
    <meta property="place:location:latitude" content="<?= e($siteGeo['latitude']) ?>">
    <meta property="place:location:longitude" content="<?= e($siteGeo['longitude']) ?>">
    <meta property="place:location:country_name" content="<?= e($siteGeo['country']) ?>">
    <meta property="article:modified_time" content="<?= e(updatedAtIsoDate(isset($site['updated_at']) && is_string($site['updated_at']) ? $site['updated_at'] : '')) ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@MyAgri">
    <meta name="twitter:title" content="<?= e($pageTitle) ?>">
    <meta name="twitter:description" content="<?= e($metaDescription) ?>">
    <meta name="twitter:image" content="<?= e($metaImage) ?>">
    <meta name="twitter:image:alt" content="Paysage agricole wallon illustrant le portail citoyen MyAgri">
    <link rel="alternate" href="<?= e($canonicalUrl) ?>" hreflang="fr-BE">
    <link rel="alternate" href="<?= e($canonicalUrl) ?>" hreflang="fr">
    <link rel="alternate" href="<?= e($canonicalUrl) ?>" hreflang="x-default">
    <meta property="article:published_time" content="<?= e(updatedAtIsoDate(isset($site['updated_at']) && is_string($site['updated_at']) ? $site['updated_at'] : '')) ?>">
    <script src="https://cdn.tailwindcss.com"></script>
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
            <nav aria-label="Navigation principale">
                <ul class="nav-list shadow-soft">
                    <li><a href="?page=accueil"<?= $page === 'accueil' ? ' aria-current="page"' : '' ?>>Accueil</a></li>
                    <li><a href="?page=filieres"<?= $page === 'filieres' ? ' aria-current="page"' : '' ?>>Filières</a></li>
                    <li><a href="?page=ressources"<?= $page === 'ressources' ? ' aria-current="page"' : '' ?>>Ressources</a></li>
                    <li><a href="?page=faq"<?= $page === 'faq' ? ' aria-current="page"' : '' ?>>FAQ</a></li>
                    <li><a href="?page=glossaire"<?= $page === 'glossaire' ? ' aria-current="page"' : '' ?>>Glossaire</a></li>
                </ul>
            </nav>
        </div>
        <section class="hero" aria-labelledby="hero-title">
            <figure class="hero-visual">
                <img src="assets/img/hero.png" alt="MyAgri rapproche les citoyens du monde agricole pour comprendre, échanger et construire une agriculture durable et locale.">
                <div class="sr-only">
                    <h1 id="hero-title"><?= e($site['title']) ?></h1>
                    <p><?= e($site['subtitle']) ?></p>
                    <p>Dernière mise à jour : <?= e($site['updated_at']) ?></p>
                </div>
            </figure>
        </section>
    </div>
</header>

<div class="container hero-search-wrap">
    <form method="get" class="search-form hero-search">
        <input type="hidden" name="page" value="<?= e($page) ?>">
        <label for="global-search" class="meta">Recherche globale</label>
        <input id="global-search" class="filter w-full rounded-xl border border-emerald-200 bg-white/95 px-3 py-2" name="q" value="<?= e($search) ?>" placeholder="Ex: eau, élevage, saison" type="search">
    </form>
</div>

<main class="container py-8">
