<?php

declare(strict_types=1);

require __DIR__ . '/includes/data.php';
?><!DOCTYPE html>
<html lang="fr-BE">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($site['title']) ?></title>
    <meta name="description" content="Portail citoyen détaillé sur l'agriculture en Wallonie : filières, enjeux, transition, glossaire et actions concrètes.">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header>
    <div class="container">
        <div class="header-top">
            <div class="brand">AgriWallonie</div>
            <nav aria-label="Navigation principale">
                <ul class="nav-list">
                    <li><a href="#bases">Comprendre</a></li>
                    <li><a href="#filieres">Filières</a></li>
                    <li><a href="#enjeux">Enjeux</a></li>
                    <li><a href="#agir">Agir</a></li>
                    <li><a href="#faq">FAQ</a></li>
                    <li><a href="#glossaire">Glossaire</a></li>
                </ul>
            </nav>
        </div>
        <div class="hero">
            <h1><?= htmlspecialchars($site['title']) ?></h1>
            <p class="subtitle"><?= htmlspecialchars($site['subtitle']) ?></p>
            <p class="meta">Dernière mise à jour du contenu : <?= htmlspecialchars($site['updated_at']) ?>.</p>
        </div>
    </div>
</header>

<main class="container">
    <section id="bases" aria-labelledby="bases-title">
        <h2 id="bases-title">Les bases à connaître</h2>
        <p class="section-intro">Une entrée rapide pour comprendre l'agriculture wallonne au sens large.</p>
        <div class="grid grid-3">
            <?php foreach ($quickFacts as $fact): ?>
                <article class="card">
                    <h3><?= htmlspecialchars($fact['title']) ?></h3>
                    <p><?= htmlspecialchars($fact['content']) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </section>

    <section aria-labelledby="piliers-title">
        <h2 id="piliers-title">4 piliers du portail</h2>
        <div class="grid grid-2 pillars">
            <?php foreach ($pillars as $pillar): ?>
                <article class="card">
                    <h3><?= htmlspecialchars($pillar['name']) ?></h3>
                    <p><?= htmlspecialchars($pillar['description']) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </section>

    <section id="filieres" aria-labelledby="filieres-title">
        <h2 id="filieres-title">Filières agricoles</h2>
        <p class="section-intro">Filtrez les filières par mot-clé (ex: lait, vergers, cultures, proximité).</p>
        <label for="sector-filter" class="meta">Rechercher dans les filières</label>
        <input id="sector-filter" class="filter" type="search" placeholder="Tapez un mot-clé..." data-sector-filter>

        <div class="grid grid-3">
            <?php foreach ($sectors as $sector): ?>
                <?php
                $searchText = mb_strtolower($sector['label'] . ' ' . $sector['summary'] . ' ' . implode(' ', $sector['enjeux']) . ' ' . $sector['bon_a_savoir']);
                ?>
                <article class="card" data-sector-card data-search-text="<?= htmlspecialchars($searchText) ?>">
                    <h3 class="sector-title"><span><?= htmlspecialchars($sector['emoji']) ?></span> <?= htmlspecialchars($sector['label']) ?></h3>
                    <p><?= htmlspecialchars($sector['summary']) ?></p>
                    <ul class="list-tight">
                        <?php foreach ($sector['enjeux'] as $enjeu): ?>
                            <li><?= htmlspecialchars($enjeu) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <p class="callout"><strong>Bon à savoir :</strong> <?= htmlspecialchars($sector['bon_a_savoir']) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </section>

    <section id="enjeux" aria-labelledby="enjeux-title">
        <h2 id="enjeux-title">Enjeux transversaux</h2>
        <div class="grid grid-2">
            <?php foreach ($focusThemes as $theme): ?>
                <article class="card">
                    <h3><?= htmlspecialchars($theme['title']) ?></h3>
                    <p><?= htmlspecialchars($theme['details']) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </section>

    <section id="agir" aria-labelledby="agir-title">
        <h2 id="agir-title">Comment agir en tant que citoyen ?</h2>
        <div class="card">
            <ul>
                <?php foreach ($citizenActions as $action): ?>
                    <li><?= htmlspecialchars($action) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

    <section id="faq" aria-labelledby="faq-title">
        <h2 id="faq-title">FAQ</h2>
        <div class="grid">
            <?php foreach ($faq as $index => $item): ?>
                <?php $answerId = 'faq-' . $index; ?>
                <article class="faq-item">
                    <button class="faq-button" type="button" aria-expanded="false" aria-controls="<?= htmlspecialchars($answerId) ?>" data-faq-button>
                        <?= htmlspecialchars($item['q']) ?>
                    </button>
                    <p id="<?= htmlspecialchars($answerId) ?>" hidden><?= htmlspecialchars($item['a']) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </section>

    <section id="glossaire" aria-labelledby="glossaire-title">
        <h2 id="glossaire-title">Glossaire</h2>
        <div class="grid grid-2">
            <?php foreach ($glossary as $entry): ?>
                <article class="card">
                    <h3><?= htmlspecialchars($entry['term']) ?></h3>
                    <p><?= htmlspecialchars($entry['definition']) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </section>
</main>

<footer>
    <div class="container">
        <p>AgriWallonie — portail grand public sur l'agriculture en Wallonie (PHP 8.5.3 compatible).</p>
    </div>
</footer>

<script src="assets/js/main.js" defer></script>
</body>
</html>
