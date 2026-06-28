<section aria-labelledby="dossiers-title" class="shadow-soft">
    <h2 id="dossiers-title"><?= e(t('dossiers.title')) ?></h2>
    <p class="section-intro"><?= e(t('dossiers.intro')) ?></p>

    <div class="grid grid-3 dossier-list">
        <?php foreach ($dossiers as $dossier): ?>
            <?php
            if (!is_array($dossier) || !isset($dossier['id'], $dossier['title']) || !is_string($dossier['id']) || !is_string($dossier['title'])) {
                continue;
            }
            $dossierText = mb_strtolower($dossier['title'] . ' ' . ($dossier['subtitle'] ?? '') . ' ' . ($dossier['audience'] ?? ''));
            if ($search !== '' && !str_contains($dossierText, mb_strtolower($search))) {
                continue;
            }
            $chapters = is_array($dossier['chapters'] ?? null) ? $dossier['chapters'] : [];
            $firstChapter = $chapters[0]['id'] ?? '';
            ?>
            <article class="card h-full dossier-card">
                <?php if (isset($dossier['illustration']) && is_string($dossier['illustration'])): ?>
                    <figure class="dossier-card-media">
                        <img class="dossier-card-image" src="<?= e($dossier['illustration']) ?>" alt="<?= e(isset($dossier['illustration_alt']) && is_string($dossier['illustration_alt']) ? $dossier['illustration_alt'] : $dossier['title']) ?>">
                    </figure>
                <?php endif; ?>
                <div class="dossier-card-body">
                    <p class="eyebrow"><?= e((string) count($chapters)) ?> <?= e(t('dossiers.chapter_nav_aria')) ?></p>
                    <h3><?= e($dossier['title']) ?></h3>
                    <?php if (isset($dossier['subtitle']) && is_string($dossier['subtitle'])): ?>
                        <p><?= e($dossier['subtitle']) ?></p>
                    <?php endif; ?>
                    <?php if (isset($dossier['audience']) && is_string($dossier['audience'])): ?>
                        <p class="tagline"><strong><?= e(t('dossiers.for')) ?>:</strong> <?= e($dossier['audience']) ?></p>
                    <?php endif; ?>
                    <p class="card-action">
                        <a class="button-link" href="<?= e(localizedUrl(['page' => 'dossier', 'dossier' => $dossier['id'], 'chapitre' => is_string($firstChapter) ? $firstChapter : ''])) ?>"><?= e(t('dossiers.cta')) ?></a>
                    </p>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>
