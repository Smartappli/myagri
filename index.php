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
$allowedPages = ['accueil', 'filieres', 'ressources', 'faq', 'glossaire', 'ressource', 'dossiers', 'dossier'];
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
$dossiers = is_array($data['dossiers'] ?? null) ? $data['dossiers'] : [];
$resourceId = isset($_GET['resource']) && is_string($_GET['resource']) ? trim($_GET['resource']) : '';
$resourcesById = [];
foreach ($resources as $resourceItem) {
    if (isset($resourceItem['id']) && is_string($resourceItem['id'])) {
        $resourcesById[$resourceItem['id']] = $resourceItem;
    }
}
$selectedResource = $resourcesById[$resourceId] ?? null;
$dossierId = isset($_GET['dossier']) && is_string($_GET['dossier']) ? trim($_GET['dossier']) : '';
$chapterId = isset($_GET['chapitre']) && is_string($_GET['chapitre']) ? trim($_GET['chapitre']) : '';
$dossiersById = [];
foreach ($dossiers as $dossierItem) {
    if (isset($dossierItem['id']) && is_string($dossierItem['id'])) {
        $dossiersById[$dossierItem['id']] = $dossierItem;
    }
}
$selectedDossier = $dossiersById[$dossierId] ?? null;
$selectedDossierChapter = null;
if ($page === 'dossier' && is_array($selectedDossier) && is_array($selectedDossier['chapters'] ?? null)) {
    $chapters = $selectedDossier['chapters'];
    $requestedChapter = $chapterId !== '' ? $chapterId : (isset($chapters[0]['id']) && is_string($chapters[0]['id']) ? $chapters[0]['id'] : '');
    foreach ($chapters as $chapterItem) {
        if (isset($chapterItem['id']) && is_string($chapterItem['id']) && $chapterItem['id'] === $requestedChapter) {
            $selectedDossierChapter = $chapterItem;
            $chapterId = $requestedChapter;
            break;
        }
    }
}
$glossaryTermSlug = '';
$selectedGlossaryTerm = null;
if ($page === 'glossaire') {
    $glossaryTermSlug = isset($_GET['term']) && is_string($_GET['term']) ? trim($_GET['term']) : '';
    $selectedGlossaryTerm = $glossaryTermSlug !== '' ? glossaryTermBySlug($glossary, glossarySlug($glossaryTermSlug)) : null;
}

$isNotFoundResource = $page === 'ressource' && !is_array($selectedResource);
$isNotFoundDossier = $page === 'dossier' && (!is_array($selectedDossier) || !is_array($selectedDossierChapter));
$isNotFoundGlossaryTerm = $page === 'glossaire' && $glossaryTermSlug !== '' && !is_array($selectedGlossaryTerm);
$shouldIndex = $shouldIndex && !$isInvalidPage && !$isNotFoundResource && !$isNotFoundDossier && !$isNotFoundGlossaryTerm;
if (!$shouldIndex) {
    http_response_code(404);
}

$seo = pageSeo(
    $page,
    $site,
    is_array($selectedResource) ? $selectedResource : null,
    is_array($selectedGlossaryTerm) ? $selectedGlossaryTerm : null,
    is_array($selectedDossier) ? $selectedDossier : null,
    is_array($selectedDossierChapter) ? $selectedDossierChapter : null
);
$canonicalResource = is_array($selectedResource) && $resourceId !== '' ? $resourceId : '';
$canonicalGlossaryTerm = is_array($selectedGlossaryTerm) && isset($selectedGlossaryTerm['term']) && is_string($selectedGlossaryTerm['term'])
    ? glossarySlug($selectedGlossaryTerm['term'])
    : '';
$canonicalDossier = is_array($selectedDossier) && isset($selectedDossier['id']) && is_string($selectedDossier['id']) ? $selectedDossier['id'] : '';
$canonicalChapter = is_array($selectedDossierChapter) && isset($selectedDossierChapter['id']) && is_string($selectedDossierChapter['id']) ? $selectedDossierChapter['id'] : '';
$canonicalUrl = siteBaseUrl() . canonicalPath($page, $canonicalResource, $canonicalGlossaryTerm, $canonicalDossier, $canonicalChapter);
$pageTitle = $seo['title'];
$metaDescription = $seo['description'];
$metaKeywords = $seo['keywords'];
$metaImage = siteBaseUrl() . '/assets/img/hero.png';
if ($page === 'dossier' && is_array($selectedDossier) && isset($selectedDossier['illustration']) && is_string($selectedDossier['illustration'])) {
    $metaImage = siteBaseUrl() . $selectedDossier['illustration'];
}
$structuredData = pageStructuredData(
    $page,
    $site,
    $sectors,
    $resources,
    $faq,
    $glossary,
    is_array($selectedResource) ? $selectedResource : null,
    is_array($selectedGlossaryTerm) ? $selectedGlossaryTerm : null,
    is_array($dossiers) ? $dossiers : [],
    is_array($selectedDossier) ? $selectedDossier : null,
    is_array($selectedDossierChapter) ? $selectedDossierChapter : null
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
    case 'dossiers':
        require __DIR__ . '/includes/views/page-dossiers.php';
        break;
    case 'dossier':
        require __DIR__ . '/includes/views/page-dossier.php';
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


