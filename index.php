<?php

declare(strict_types=1);

require __DIR__ . '/includes/data.php';
?><!DOCTYPE html>
<html lang="fr-BE">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portail Agriculture Wallonie</title>
    <meta name="description" content="Portail d'information sur l'agriculture wallonne : filières, pratiques durables, enjeux et ressources pour le grand public.">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header>
    <div class="container">
        <h1><?= htmlspecialchars($hero['title']) ?></h1>
        <p class="hero-subtitle"><?= htmlspecialchars($hero['subtitle']) ?></p>
        <a class="button" href="#filieres"><?= htmlspecialchars($hero['cta']) ?></a>
    </div>
</header>

<main class="container">
    <section aria-labelledby="chiffres-cles">
        <h2 id="chiffres-cles">Repères essentiels</h2>
        <p class="small">Une vue synthétique pour comprendre les dynamiques agricoles régionales.</p>
        <div class="grid stats-grid">
            <?php foreach ($stats as $stat): ?>
                <article class="card">
                    <p class="tag"><?= htmlspecialchars($stat['label']) ?></p>
                    <h3><?= htmlspecialchars($stat['value']) ?></h3>
                    <p><?= htmlspecialchars($stat['description']) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </section>

    <section id="filieres" aria-labelledby="filieres-title">
        <h2 id="filieres-title">Filières agricoles en Wallonie</h2>
        <p class="small">Des productions complémentaires qui structurent l'économie et l'alimentation locale.</p>
        <div class="grid sector-grid">
            <?php foreach ($sectors as $sector): ?>
                <article class="card">
                    <h3 class="sector-title"><span><?= $sector['icon'] ?></span> <?= htmlspecialchars($sector['name']) ?></h3>
                    <p><?= htmlspecialchars($sector['focus']) ?></p>
                    <ul>
                        <?php foreach ($sector['public_info'] as $line): ?>
                            <li><?= htmlspecialchars($line) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </article>
            <?php endforeach; ?>
        </div>
    </section>

    <section aria-labelledby="transitions-title">
        <h2 id="transitions-title">Transitions et innovations</h2>
        <div class="timeline">
            <?php foreach ($initiatives as $initiative): ?>
                <article class="card">
                    <h3><?= htmlspecialchars($initiative['title']) ?></h3>
                    <p><?= htmlspecialchars($initiative['description']) ?></p>
                    <p><strong>Impact public :</strong> <?= htmlspecialchars($initiative['impact']) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </section>

    <section aria-labelledby="faq-title">
        <h2 id="faq-title">Questions fréquentes</h2>
        <?php foreach ($faq as $item): ?>
            <article class="faq-item">
                <h3><?= htmlspecialchars($item['q']) ?></h3>
                <p><?= htmlspecialchars($item['a']) ?></p>
            </article>
        <?php endforeach; ?>
    </section>

    <section aria-labelledby="ressources-title">
        <h2 id="ressources-title">Ressources citoyennes</h2>
        <div class="grid stats-grid">
            <?php foreach ($resources as $resource): ?>
                <article class="card">
                    <h3><?= htmlspecialchars($resource['name']) ?></h3>
                    <p><?= htmlspecialchars($resource['description']) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </section>
</main>

<footer>
    <div class="container">
        <p>Portail d'information grand public sur l'agriculture en Wallonie — version PHP 8.5.3 compatible.</p>
    </div>
</footer>
</body>
</html>
