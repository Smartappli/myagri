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
