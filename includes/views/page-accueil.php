<section aria-labelledby="start-title" class="section-feature">
    <div class="section-heading">
        <p class="eyebrow">Comprendre, choisir, transmettre</p>
        <h2 id="start-title">Par où commencer ?</h2>
        <p class="section-intro">MyAgri organise l’information agricole wallonne autour de trois usages simples : comprendre les filières, préparer une action concrète et vérifier le vocabulaire avant d’en parler.</p>
    </div>
    <div class="grid grid-3 action-grid">
        <article class="action-card">
            <h3>Comprendre une filière</h3>
            <p>Repérez les productions, les contraintes de terrain et les leviers citoyens associés.</p>
            <a class="button-link" href="?page=filieres">Explorer les filières</a>
        </article>
        <article class="action-card">
            <h3>Préparer une action</h3>
            <p>Utilisez les guides pour une visite, un achat local, un atelier, une orientation ou un projet.</p>
            <a class="button-link" href="?page=ressources">Voir les ressources</a>
        </article>
        <article class="action-card">
            <h3>Clarifier un mot</h3>
            <p>Consultez les définitions utiles pour lire un article, préparer un cours ou comparer des démarches.</p>
            <a class="button-link" href="?page=glossaire">Ouvrir le glossaire</a>
        </article>
    </div>
</section>

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
