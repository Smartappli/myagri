<section aria-labelledby="dossiers-title" class="shadow-soft">
    <h2 id="dossiers-title">Dossiers thématiques citoyens</h2>
    <p class="section-intro">Des parcours illustrés, découpés en chapitres courts, pour comprendre les grands sujets agricoles wallons avec des repères pratiques et des références vérifiables.</p>

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
                    <p class="eyebrow"><?= count($chapters) ?> chapitres</p>
                    <h3><?= e($dossier['title']) ?></h3>
                    <?php if (isset($dossier['subtitle']) && is_string($dossier['subtitle'])): ?>
                        <p><?= e($dossier['subtitle']) ?></p>
                    <?php endif; ?>
                    <?php if (isset($dossier['audience']) && is_string($dossier['audience'])): ?>
                        <p class="tagline"><strong>Pour :</strong> <?= e($dossier['audience']) ?></p>
                    <?php endif; ?>
                    <p class="card-action">
                        <a class="button-link" href="?page=dossier&amp;dossier=<?= e($dossier['id']) ?><?= is_string($firstChapter) && $firstChapter !== '' ? '&amp;chapitre=' . e($firstChapter) : '' ?>">Lire le dossier</a>
                    </p>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>
