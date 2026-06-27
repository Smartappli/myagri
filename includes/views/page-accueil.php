<section aria-labelledby="start-title" class="section-feature">
    <div class="section-heading">
        <p class="eyebrow">Verstehen, entscheiden, weitergeben</p>
        <h2 id="start-title">Wo anfangen?</h2>
        <p class="section-intro">MyAgri ordnet Informationen zur wallonischen Landwirtschaft nach klaren Nutzungen: Sektoren verstehen, konkrete Schritte vorbereiten und Begriffe prüfen, bevor man darüber spricht.</p>
    </div>
    <div class="grid grid-3 action-grid">
        <article class="action-card">
            <h3>Einen Sektor verstehen</h3>
            <p>Erkennen Sie Produktionen, praktische Zwänge und passende Handlungsmöglichkeiten.</p>
            <a class="button-link" href="?page=filieres">Sektoren erkunden</a>
        </article>
        <article class="action-card">
            <h3>Eine Aktion vorbereiten</h3>
            <p>Nutzen Sie die Leitfäden für Besuche, lokale Einkäufe, Workshops, Orientierung oder Projekte.</p>
            <a class="button-link" href="?page=ressources">Ressourcen ansehen</a>
        </article>
        <article class="action-card">
            <h3>Einen Begriff klären</h3>
            <p>Nutzen Sie Definitionen, um Artikel zu lesen, Unterricht vorzubereiten oder Ansätze zu vergleichen.</p>
            <a class="button-link" href="?page=glossaire">Glossar öffnen</a>
        </article>
        <article class="action-card">
            <h3>Ein Thema vertiefen</h3>
            <p>Lesen Sie illustrierte Dossiers mit kurzen Kapiteln, Orientierungspunkten und überprüfbaren Quellen.</p>
            <a class="button-link" href="?page=dossiers">Dossiers ansehen</a>
        </article>
    </div>
</section>

<section aria-labelledby="bases-title" class="shadow-soft">
    <h2 id="bases-title">Grundlagen</h2>
    <div class="grid grid-3">
        <?php foreach ($quickFacts as $fact): ?>
            <article class="card h-full">
                <h3><?= e($fact['title']) ?></h3>
                <p><?= e($fact['content']) ?></p>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<?php if ($editorialPrinciples !== []): ?>
<section aria-labelledby="editorial-title" class="shadow-soft">
    <div class="section-heading">
        <p class="eyebrow">Redaktionelle Methode</p>
        <h2 id="editorial-title">Eigene Inhalte, überprüfbare Quellen</h2>
        <p class="section-intro">MyAgri sammelt keine kopierten Definitionen. Das Portal formuliert neu, ordnet ein und zeigt, wann Informationen bei einer zuständigen Stelle geprüft werden sollten.</p>
    </div>
    <div class="grid grid-2">
        <?php foreach ($editorialPrinciples as $principle): ?>
            <?php
            if (!is_array($principle)) {
                continue;
            }
            $principleTitle = isset($principle['title']) && is_string($principle['title']) ? $principle['title'] : '';
            $principleContent = isset($principle['content']) && is_string($principle['content']) ? $principle['content'] : '';
            if ($principleTitle === '' && $principleContent === '') {
                continue;
            }
            ?>
            <article class="card h-full">
                <?php if ($principleTitle !== ''): ?>
                    <h3><?= e($principleTitle) ?></h3>
                <?php endif; ?>
                <?php if ($principleContent !== ''): ?>
                    <p><?= e($principleContent) ?></p>
                <?php endif; ?>
            </article>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<section aria-labelledby="pillars-title" class="shadow-soft">
    <h2 id="pillars-title">Die 4 Säulen</h2>
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
    <h2 id="themes-title">Querschnittsthemen</h2>
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
    <h2 id="provinces-title">Nach Provinz lesen</h2>
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
    <h2 id="calendar-title">Vereinfachter Agrarkalender</h2>
    <div class="grid grid-2">
        <?php foreach ($seasonalCalendar as $entry): ?>
            <article class="card h-full">
                <h3><?= e($entry['season']) ?></h3>
                <p><?= e($entry['focus']) ?></p>
            </article>
        <?php endforeach; ?>
    </div>
</section>
