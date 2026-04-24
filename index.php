<?php

declare(strict_types=1);

require __DIR__ . '/includes/data.php';
require __DIR__ . '/includes/functions.php';

$data = getPortalData();
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
?><!DOCTYPE html>
<html lang="fr-BE">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($site['title']) ?></title>
    <meta name="description" content="Portail citoyen détaillé sur l'agriculture en Wallonie.">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header>
    <div class="container">
        <div class="header-top">
            <div class="brand">MyAgri</div>
            <nav aria-label="Navigation principale">
                <ul class="nav-list">
                    <li><a href="?page=accueil"<?= $page === 'accueil' ? ' aria-current="page"' : '' ?>>Accueil</a></li>
                    <li><a href="?page=filieres"<?= $page === 'filieres' ? ' aria-current="page"' : '' ?>>Filières</a></li>
                    <li><a href="?page=ressources"<?= $page === 'ressources' ? ' aria-current="page"' : '' ?>>Ressources</a></li>
                </ul>
            </nav>
        </div>
        <div class="hero">
            <h1><?= e($site['title']) ?></h1>
            <p class="subtitle"><?= e($site['subtitle']) ?></p>
            <p class="meta">Dernière mise à jour : <?= e($site['updated_at']) ?></p>
            <form method="get" class="search-form">
                <input type="hidden" name="page" value="<?= e($page) ?>">
                <label for="global-search" class="meta">Recherche globale</label>
                <input id="global-search" class="filter" name="q" value="<?= e($search) ?>" placeholder="Ex: eau, élevage, saison" type="search">
            </form>
        </div>
    </div>
</header>

<main class="container">
    <?php if ($page === 'accueil'): ?>
        <section aria-labelledby="bases-title">
            <h2 id="bases-title">Les bases à connaître</h2>
            <div class="grid grid-3">
                <?php foreach ($quickFacts as $fact): ?>
                    <article class="card">
                        <h3><?= e($fact['title']) ?></h3>
                        <p><?= e($fact['content']) ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <section aria-labelledby="pillars-title">
            <h2 id="pillars-title">Les 4 piliers</h2>
            <div class="grid grid-2 pillars">
                <?php foreach ($pillars as $pillar): ?>
                    <article class="card">
                        <h3><?= e($pillar['name']) ?></h3>
                        <p><?= e($pillar['description']) ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <section aria-labelledby="themes-title">
            <h2 id="themes-title">Enjeux transversaux</h2>
            <div class="grid grid-2">
                <?php foreach ($focusThemes as $theme): ?>
                    <article class="card">
                        <h3><?= e($theme['title']) ?></h3>
                        <p><?= e($theme['details']) ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <section aria-labelledby="provinces-title">
            <h2 id="provinces-title">Lecture par province</h2>
            <div class="grid grid-3">
                <?php foreach ($provinces as $province): ?>
                    <article class="card">
                        <h3><?= e($province['name']) ?></h3>
                        <p><?= e($province['profile']) ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <section aria-labelledby="calendar-title">
            <h2 id="calendar-title">Calendrier agricole simplifié</h2>
            <div class="grid grid-2">
                <?php foreach ($seasonalCalendar as $entry): ?>
                    <article class="card">
                        <h3><?= e($entry['season']) ?></h3>
                        <p><?= e($entry['focus']) ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

    <?php if ($page === 'filieres'): ?>
        <section aria-labelledby="filieres-title">
            <h2 id="filieres-title">Explorer les filières</h2>
            <p class="section-intro">Filtrage local (JavaScript) + recherche globale via champ en haut.</p>
            <label for="sector-filter" class="meta">Filtre local</label>
            <input id="sector-filter" class="filter" type="search" placeholder="Ex: lait, saison, cultures" data-sector-filter>
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
        <section aria-labelledby="faq-title">
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
                    <article class="faq-item">
                        <button class="faq-button" type="button" aria-expanded="false" aria-controls="<?= e($answerId) ?>" data-faq-button>
                            <?= e($item['q']) ?>
                        </button>
                        <p id="<?= e($answerId) ?>" hidden><?= e($item['a']) ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <section aria-labelledby="resources-title">
            <h2 id="resources-title">Ressources utiles</h2>
            <div class="grid grid-3">
                <?php foreach ($resources as $resource): ?>
                    <?php
                    $resourceText = mb_strtolower($resource['title'] . ' ' . $resource['description']);
                    if ($search !== '' && !str_contains($resourceText, mb_strtolower($search))) {
                        continue;
                    }
                    ?>
                    <article class="card">
                        <h3><?= e($resource['title']) ?></h3>
                        <p><?= e($resource['description']) ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <section aria-labelledby="glossary-title">
            <h2 id="glossary-title">Glossaire</h2>
            <div class="grid grid-2">
                <?php foreach ($glossary as $entry): ?>
                    <?php
                    $glossaryText = mb_strtolower($entry['term'] . ' ' . $entry['definition']);
                    if ($search !== '' && !str_contains($glossaryText, mb_strtolower($search))) {
                        continue;
                    }
                    ?>
                    <article class="card">
                        <h3><?= e($entry['term']) ?></h3>
                        <p><?= e($entry['definition']) ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>
</main>

<footer>
    <div class="container">
        <p>MyAgri — portail d'information agricole grand public (compatible PHP 8.5.3).</p>
    </div>
</footer>

<script src="assets/js/main.js" defer></script>
</body>
</html>
