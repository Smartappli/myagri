<section aria-labelledby="start-title" class="section-feature">
    <div class="section-heading">
        <p class="eyebrow"><?= e(t('home.eyebrow')) ?></p>
        <h2 id="start-title"><?= e(t('home.title')) ?></h2>
        <p class="section-intro"><?= e(t('home.intro')) ?></p>
    </div>
    <div class="grid grid-3 action-grid">
        <article class="action-card">
            <h3><?= e(t('home.card_sector_title')) ?></h3>
            <p><?= e(t('home.card_sector_text')) ?></p>
            <a class="button-link" href="<?= e(localizedUrl(['page' => 'filieres'])) ?>"><?= e(t('home.card_sector_cta')) ?></a>
        </article>
        <article class="action-card">
            <h3><?= e(t('home.card_action_title')) ?></h3>
            <p><?= e(t('home.card_action_text')) ?></p>
            <a class="button-link" href="<?= e(localizedUrl(['page' => 'ressources'])) ?>"><?= e(t('home.card_action_cta')) ?></a>
        </article>
        <article class="action-card">
            <h3><?= e(t('home.card_term_title')) ?></h3>
            <p><?= e(t('home.card_term_text')) ?></p>
            <a class="button-link" href="<?= e(localizedUrl(['page' => 'glossaire'])) ?>"><?= e(t('home.card_term_cta')) ?></a>
        </article>
        <article class="action-card">
            <h3><?= e(t('home.card_dossier_title')) ?></h3>
            <p><?= e(t('home.card_dossier_text')) ?></p>
            <a class="button-link" href="<?= e(localizedUrl(['page' => 'dossiers'])) ?>"><?= e(t('home.card_dossier_cta')) ?></a>
        </article>
    </div>
</section>

<section aria-labelledby="bases-title" class="shadow-soft">
    <h2 id="bases-title"><?= e(t('home.basics_title')) ?></h2>
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
        <p class="eyebrow"><?= e(t('home.editorial_eyebrow')) ?></p>
        <h2 id="editorial-title"><?= e(t('home.editorial_title')) ?></h2>
        <p class="section-intro"><?= e(t('home.editorial_intro')) ?></p>
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
    <h2 id="pillars-title"><?= e(t('home.pillars_title')) ?></h2>
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
    <h2 id="themes-title"><?= e(t('home.themes_title')) ?></h2>
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
    <h2 id="provinces-title"><?= e(t('home.provinces_title')) ?></h2>
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
    <h2 id="calendar-title"><?= e(t('home.calendar_title')) ?></h2>
    <div class="grid grid-2">
        <?php foreach ($seasonalCalendar as $entry): ?>
            <article class="card h-full">
                <h3><?= e($entry['season']) ?></h3>
                <p><?= e($entry['focus']) ?></p>
            </article>
        <?php endforeach; ?>
    </div>
</section>
