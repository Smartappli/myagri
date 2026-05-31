<?php declare(strict_types=1);


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

$requestedPage = isset($_GET['page']) && is_string($_GET['page']) ? trim($_GET['page']) : 'accueil';
$allowedPages = ['accueil', 'filieres', 'ressources', 'faq', 'glossaire', 'ressource'];
$page = currentPage();
$search = isset($_GET['q']) && is_string($_GET['q']) ? trim($_GET['q']) : '';
$shouldIndex = true;
$isInvalidPage = $requestedPage !== '' && !in_array($requestedPage, $allowedPages, true);

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
$glossaryTermSlug = '';
$selectedGlossaryTerm = null;
if ($page === 'glossaire') {
    $glossaryTermSlug = isset($_GET['term']) && is_string($_GET['term']) ? trim($_GET['term']) : '';
    $selectedGlossaryTerm = $glossaryTermSlug !== '' ? glossaryTermBySlug($glossary, glossarySlug($glossaryTermSlug)) : null;
}

$isNotFoundResource = $page === 'ressource' && !is_array($selectedResource);
$isNotFoundGlossaryTerm = $page === 'glossaire' && $glossaryTermSlug !== '' && !is_array($selectedGlossaryTerm);
$shouldIndex = $shouldIndex && !$isInvalidPage && !$isNotFoundResource && !$isNotFoundGlossaryTerm;
if (!$shouldIndex) {
    http_response_code(404);
}

$seo = pageSeo($page, $site, is_array($selectedResource) ? $selectedResource : null, is_array($selectedGlossaryTerm) ? $selectedGlossaryTerm : null);
$canonicalResource = is_array($selectedResource) && $resourceId !== '' ? $resourceId : '';
$canonicalGlossaryTerm = is_array($selectedGlossaryTerm) && isset($selectedGlossaryTerm['term']) && is_string($selectedGlossaryTerm['term'])
    ? glossarySlug($selectedGlossaryTerm['term'])
    : '';
$canonicalUrl = siteBaseUrl() . canonicalPath($page, $canonicalResource, $canonicalGlossaryTerm);
$pageTitle = $seo['title'];
$metaDescription = $seo['description'];
$metaKeywords = $seo['keywords'];
$metaImage = siteBaseUrl() . '/assets/img/hero.png';
$structuredData = pageStructuredData(
    $page,
    $site,
    $sectors,
    $resources,
    $faq,
    $glossary,
    is_array($selectedResource) ? $selectedResource : null,
    is_array($selectedGlossaryTerm) ? $selectedGlossaryTerm : null
);
$allowIndex = $shouldIndex;

$pageFaqPairs = [];
if ($page === 'ressource' && is_array($selectedResource)) {
    $pageFaqPairs = resourceFaqPairs($selectedResource);
}
if ($page === 'glossaire' && is_array($selectedGlossaryTerm)) {
    $pageFaqPairs = glossaryTermFaqPairs($selectedGlossaryTerm);
}

require __DIR__ . '/includes/partials/head.php';

switch ($page) {
    case 'accueil':
        require __DIR__ . '/includes/views/page-accueil.php';
        break;
    case 'filieres':
        require __DIR__ . '/includes/views/page-filieres.php';
        break;
    case 'ressources':
        require __DIR__ . '/includes/views/page-ressources.php';
        break;
    case 'faq':
        require __DIR__ . '/includes/views/page-faq.php';
        break;
    case 'glossaire':
        require __DIR__ . '/includes/views/page-glossaire.php';
        break;
    case 'ressource':
        require __DIR__ . '/includes/views/page-ressource.php';
        break;
    default:
        require __DIR__ . '/includes/views/page-accueil.php';
        break;
}

if ($pageFaqPairs !== []) {
    $qaTitle = $page === 'ressource' ? 'Questions autour de cette ressource' : 'Questions autour de ce terme';
    $qaIntro = 'Reponses rapides pour la recherche et la relecture :';
    require __DIR__ . '/includes/partials/page-qa-block.php';
}

require __DIR__ . '/includes/partials/footer.php';


