<?php

declare(strict_types=1);

require __DIR__ . '/includes/portal_repository.php';
require __DIR__ . '/includes/functions.php';

$data = [];
$dataLoadError = null;
try {
    $data = loadPortalData();
} catch (Throwable $exception) {
    $dataLoadError = $exception->getMessage();
}

if (!is_array($data) || $dataLoadError !== null) {
    http_response_code(503);
    ?><!DOCTYPE html>
    <html lang="fr-BE">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Service temporairement indisponible — MyAgri</title>
        <meta name="robots" content="noindex, nofollow">
    </head>
    <body>
        <main>
            <h1>Service temporairement indisponible</h1>
            <p>La base de données MySQL du portail est momentanément inaccessible.</p>
            <?php if (is_string($dataLoadError) && $dataLoadError !== ''): ?>
                <p><small><?= e($dataLoadError) ?></small></p>
            <?php endif; ?>
        </main>
    </body>
    </html>
    <?php
    exit;
}

$page = currentPage();
$search = isset($_GET['q']) && is_string($_GET['q']) ? trim($_GET['q']) : '';

$site = $data['site'];
$quickFacts = $data['quickFacts'];
$pillars = $data['pillars'];
$sectors = $data['sectors'];
$focusThemes = $data['focusThemes'];
$provinces = $data['provinces'];
$seasonalCalendar = $data['seasonalCalendar'];
$faq = $data['faq'];
$glossary = $data['glossary'];
$resources = $data['resources'];
$resourceId = isset($_GET['resource']) && is_string($_GET['resource']) ? trim($_GET['resource']) : '';
$resourcesById = [];
foreach ($resources as $resourceItem) {
    if (isset($resourceItem['id']) && is_string($resourceItem['id'])) {
        $resourcesById[$resourceItem['id']] = $resourceItem;
    }
}
$selectedResource = $resourcesById[$resourceId] ?? null;
$seo = pageSeo($page, $site, is_array($selectedResource) ? $selectedResource : null);
$canonicalUrl = siteBaseUrl() . canonicalPath($page, $resourceId);
$pageTitle = $seo['title'];
$metaDescription = $seo['description'];
$metaKeywords = $seo['keywords'];
$metaImage = siteBaseUrl() . '/assets/img/og-default.svg';

?><!DOCTYPE html>
<html lang="fr-BE">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?></title>
    <meta name="description" content="<?= e($metaDescription) ?>">
    <meta name="keywords" content="<?= e($metaKeywords) ?>">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <link rel="canonical" href="<?= e($canonicalUrl) ?>">
    <meta property="og:locale" content="fr_BE">
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= e($pageTitle) ?>">
    <meta property="og:description" content="<?= e($metaDescription) ?>">
    <meta property="og:url" content="<?= e($canonicalUrl) ?>">
    <meta property="og:site_name" content="<?= e($site['title']) ?>">
    <meta property="og:image" content="<?= e($metaImage) ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= e($pageTitle) ?>">
    <meta name="twitter:description" content="<?= e($metaDescription) ?>">
    <meta name="twitter:image" content="<?= e($metaImage) ?>">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <script type="application/ld+json">
        <?= json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
            'name' => $pageTitle,
            'description' => $metaDescription,
            'url' => $canonicalUrl,
            'inLanguage' => 'fr-BE',
            'isPartOf' => [
                '@type' => 'WebSite',
                'name' => $site['title'],
                'url' => siteBaseUrl(),
            ],
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>
    </script>
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
<header class="relative overflow-hidden">
    <div class="container">
        <div class="header-top">
            <nav aria-label="Navigation principale">
                <ul class="nav-list shadow-soft">
                    <li><a href="?page=accueil"<?= $page === 'accueil' ? ' aria-current="page"' : '' ?>>Accueil</a></li>
                    <li><a href="?page=filieres"<?= $page === 'filieres' ? ' aria-current="page"' : '' ?>>Filières</a></li>
                    <li><a href="?page=ressources"<?= $page === 'ressources' ? ' aria-current="page"' : '' ?>>Ressources</a></li>
                </ul>
            </nav>
        </div>
        <div class="hero backdrop-blur-sm">
            <h1><?= e($site['title']) ?></h1>
            <p class="subtitle"><?= e($site['subtitle']) ?></p>
            <p class="meta">Dernière mise à jour : <?= e($site['updated_at']) ?></p>
            <form method="get" class="search-form">
                <input type="hidden" name="page" value="<?= e($page) ?>">
                <label for="global-search" class="meta">Recherche globale</label>
                <input id="global-search" class="filter w-full rounded-xl border border-emerald-200 bg-white/95 px-3 py-2" name="q" value="<?= e($search) ?>" placeholder="Ex: eau, élevage, saison" type="search">
            </form>
        </div>
    </div>
</header>

<main class="container py-8">
    <?php if ($page === 'accueil'): ?>
        <section aria-labelledby="bases-title" class="shadow-soft">
            <h2 id="bases-title">Les bases à connaître</h2>
            <div class="grid grid-3">
                <?php foreach ($quickFacts as $fact): ?>
                    <article class="card h-full">
                        <h3><?= e($fact['title']) ?></h3>
                        <p><?= e($fact['content']) ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <section aria-labelledby="pillars-title" class="shadow-soft">
            <h2 id="pillars-title">Les 4 piliers</h2>
            <div class="grid grid-2 pillars">
                <?php foreach ($pillars as $pillar): ?>
                    <article class="card h-full">
                        <h3><?= e($pillar['name']) ?></h3>
                        <p><?= e($pillar['description']) ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <section aria-labelledby="themes-title" class="shadow-soft">
            <h2 id="themes-title">Enjeux transversaux</h2>
            <div class="grid grid-2">
                <?php foreach ($focusThemes as $theme): ?>
                    <article class="card h-full">
                        <h3><?= e($theme['title']) ?></h3>
                        <p><?= e($theme['details']) ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <section aria-labelledby="provinces-title" class="shadow-soft">
            <h2 id="provinces-title">Lecture par province</h2>
            <div class="grid grid-3">
                <?php foreach ($provinces as $province): ?>
                    <article class="card h-full">
                        <h3><?= e($province['name']) ?></h3>
                        <p><?= e($province['profile']) ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <section aria-labelledby="calendar-title" class="shadow-soft">
            <h2 id="calendar-title">Calendrier agricole simplifié</h2>
            <div class="grid grid-2">
                <?php foreach ($seasonalCalendar as $entry): ?>
                    <article class="card h-full">
                        <h3><?= e($entry['season']) ?></h3>
                        <p><?= e($entry['focus']) ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

    <?php if ($page === 'filieres'): ?>
        <section aria-labelledby="filieres-title" class="shadow-soft">
            <h2 id="filieres-title">Explorer les filières</h2>
            <input id="sector-filter" class="filter w-full rounded-xl border border-emerald-200 bg-white/95 px-3 py-2" type="search" placeholder="Ex: lait, saison, cultures" aria-label="Filtrer les filières" data-sector-filter>
            <div class="grid grid-3">
                <?php foreach ($sectors as $sector): ?>
                    <?php
                    $searchText = mb_strtolower($sector['label'] . ' ' . $sector['summary'] . ' ' . implode(' ', $sector['enjeux']) . ' ' . implode(' ', $sector['public_actions']));
                    if ($search !== '' && !str_contains($searchText, mb_strtolower($search))) {
                        continue;
                    }
                    ?>
                    <article class="card" data-sector-card data-search-text="<?= e($searchText) ?>">
                        <h3 class="sector-title"><span><?= e($sector['emoji']) ?></span> <?= e($sector['label']) ?></h3>
                        <p><?= e($sector['summary']) ?></p>
                        <h4>Enjeux</h4>
                        <ul class="list-tight">
                            <?php foreach ($sector['enjeux'] as $item): ?>
                                <li><?= e($item) ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <h4>Que peut faire le citoyen ?</h4>
                        <ul class="list-tight">
                            <?php foreach ($sector['public_actions'] as $item): ?>
                                <li><?= e($item) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

    <?php if ($page === 'ressources'): ?>
        <section aria-labelledby="faq-title" class="shadow-soft">
            <h2 id="faq-title">FAQ citoyenne</h2>
            <div class="grid">
                <?php foreach ($faq as $index => $item): ?>
                    <?php
                    $answerText = mb_strtolower($item['q'] . ' ' . $item['a']);
                    if ($search !== '' && !str_contains($answerText, mb_strtolower($search))) {
                        continue;
                    }
                    $answerId = 'faq-' . $index;
                    ?>
                    <article class="faq-item shadow-sm ring-1 ring-emerald-100">
                        <button class="faq-button" type="button" aria-expanded="false" aria-controls="<?= e($answerId) ?>" data-faq-button>
                            <?= e($item['q']) ?>
                        </button>
                        <p id="<?= e($answerId) ?>" hidden><?= e($item['a']) ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <section aria-labelledby="resources-title" class="shadow-soft">
            <h2 id="resources-title">Ressources utiles</h2>
            <div class="grid grid-3">
                <?php foreach ($resources as $resource): ?>
                    <?php
                    $resourceText = mb_strtolower($resource['title'] . ' ' . $resource['description'] . ' ' . ($resource['overview'] ?? '') . ' ' . ($resource['for'] ?? ''));
                    if ($search !== '' && !str_contains($resourceText, mb_strtolower($search))) {
                        continue;
                    }
                    ?>
                    <article class="card h-full">
                        <h3><?= e($resource['title']) ?></h3>
                        <p><?= e($resource['description']) ?></p>
                        <?php if (isset($resource['id']) && is_string($resource['id'])): ?>
                            <p><a href="?page=ressource&amp;resource=<?= e($resource['id']) ?>">Voir la page détaillée</a></p>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <section aria-labelledby="glossary-title" class="shadow-soft">
            <h2 id="glossary-title">Glossaire</h2>
            <div class="grid grid-2">
                <?php foreach ($glossary as $entry): ?>
                    <?php
                    $glossaryText = mb_strtolower($entry['term'] . ' ' . $entry['definition']);
                    if ($search !== '' && !str_contains($glossaryText, mb_strtolower($search))) {
                        continue;
                    }
                    ?>
                    <article class="card h-full">
                        <h3><?= e($entry['term']) ?></h3>
                        <p><?= e($entry['definition']) ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

    <?php if ($page === 'ressource'): ?>
        <?php if (is_array($selectedResource)): ?>
            <section aria-labelledby="resource-title" class="shadow-soft">
                <p><a href="?page=ressources">← Retour aux ressources</a></p>
                <h2 id="resource-title"><?= e($selectedResource['title']) ?></h2>
                <p class="section-intro"><?= e($selectedResource['description']) ?></p>
                <article class="card h-full">
                    <?php
                    $continuousContent = $selectedResource['continuous_content'] ?? null;
                    if (is_string($continuousContent) && trim($continuousContent) !== ''):
                    ?>
                        <p><?= e($continuousContent) ?></p>
                    <?php else: ?>
                        <?php
                        $resourceNarrativeParts = [];
                        if (isset($selectedResource['overview']) && is_string($selectedResource['overview']) && $selectedResource['overview'] !== '') {
                            $resourceNarrativeParts[] = $selectedResource['overview'];
                        }
                        if (isset($selectedResource['for']) && is_string($selectedResource['for']) && $selectedResource['for'] !== '') {
                            $resourceNarrativeParts[] = 'Public concerné : ' . $selectedResource['for'];
                        }

                        $resourceSections = [
                            'steps' => 'Étapes recommandées',
                            'checklist' => 'Checklist pratique',
                            'eligible_projects' => 'Projets généralement éligibles',
                            'required_documents' => 'Documents souvent demandés',
                            'timeline' => 'Chronologie indicative',
                            'common_pitfalls' => 'Erreurs fréquentes à éviter',
                            'support_contacts' => 'Acteurs pouvant accompagner',
                            'learning_objectives' => 'Objectifs pédagogiques',
                            'recommended_program' => 'Déroulé recommandé',
                            'age_adaptations' => 'Adaptation selon l’âge du public',
                            'pedagogical_activities' => 'Exemples d’activités pédagogiques',
                            'risk_prevention' => 'Prévention et sécurité',
                            'budget_items' => 'Postes de budget à prévoir',
                            'evaluation_method' => 'Méthode d’évaluation',
                            'job_families' => 'Familles de métiers',
                            'training_paths' => 'Parcours de formation',
                            'key_skills' => 'Compétences clés à développer',
                            'certifications' => 'Certifications utiles',
                            'financing_options' => 'Options de financement',
                            'application_tips' => 'Conseils de candidature',
                            'salary_factors' => 'Facteurs qui influencent la rémunération',
                            'mobility_paths' => 'Évolutions professionnelles possibles',
                            'action_plan_90_days' => 'Plan d’action sur 90 jours',
                            'purchase_strategy' => 'Stratégie d’achat responsable',
                            'label_reading' => 'Lecture des labels et étiquettes',
                            'seasonal_planning' => 'Planification saisonnière',
                            'anti_waste_playbook' => 'Plan anti-gaspillage',
                            'nutrition_balance' => 'Équilibre nutritionnel',
                            'budget_optimisation' => 'Optimisation du budget',
                            'kpi_tracking' => 'Indicateurs de suivi',
                        ];

                        foreach ($resourceSections as $sectionKey => $sectionTitle) {
                            $sectionItems = $selectedResource[$sectionKey] ?? null;
                            if (!is_array($sectionItems) || $sectionItems === []) {
                                continue;
                            }

                            $sectionText = resourceContinuousText($sectionItems);
                            if ($sectionText === '') {
                                continue;
                            }

                            $resourceNarrativeParts[] = $sectionTitle . ' : ' . $sectionText;
                        }
                        ?>
                        <p><?= e(implode(' ', $resourceNarrativeParts)) ?></p>
                    <?php endif; ?>
                </article>
            </section>
        <?php else: ?>
            <section aria-labelledby="resource-not-found-title">
                <h2 id="resource-not-found-title">Ressource introuvable</h2>
                <p>La ressource demandée n’existe pas ou n’est plus disponible.</p>
                <p><a href="?page=ressources">Retour à la liste des ressources</a></p>
            </section>
        <?php endif; ?>
    <?php endif; ?>
</main>

<footer>
    <div class="container">
        <p>MyAgri — portail d'information agricole grand public.</p>
        <p class="meta">Dernière mise à jour : <?= e($site['updated_at']) ?></p>
    </div>
</footer>


<script src="assets/js/main.js" defer></script>
</body>
</html>
