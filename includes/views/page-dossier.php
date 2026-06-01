<?php
if (!is_array($selectedDossier) || !is_array($selectedDossierChapter)) {
    ?>
    <section aria-labelledby="dossier-not-found-title">
        <h2 id="dossier-not-found-title">Dossier introuvable</h2>
        <p>Le dossier demandé n’existe pas ou n’est plus disponible.</p>
        <p><a href="?page=dossiers">Retour aux dossiers</a></p>
    </section>
    <?php
    return;
}

$chapters = is_array($selectedDossier['chapters'] ?? null) ? $selectedDossier['chapters'] : [];
$references = is_array($selectedDossier['references'] ?? null) ? $selectedDossier['references'] : [];
$currentChapterId = isset($selectedDossierChapter['id']) && is_string($selectedDossierChapter['id']) ? $selectedDossierChapter['id'] : '';
?>

<section aria-labelledby="dossier-title" class="shadow-soft dossier-detail">
    <p><a href="?page=dossiers">Retour aux dossiers</a></p>

    <div class="dossier-hero">
        <div>
            <p class="eyebrow">Dossier citoyen</p>
            <h2 id="dossier-title"><?= e($selectedDossier['title']) ?></h2>
            <?php if (isset($selectedDossier['subtitle']) && is_string($selectedDossier['subtitle'])): ?>
                <p class="section-intro"><?= e($selectedDossier['subtitle']) ?></p>
            <?php endif; ?>
            <p class="meta">
                <?php if (isset($selectedDossier['duration']) && is_string($selectedDossier['duration'])): ?>
                    <?= e($selectedDossier['duration']) ?>
                <?php endif; ?>
                <?php if (isset($selectedDossier['audience']) && is_string($selectedDossier['audience'])): ?>
                    · Pour : <?= e($selectedDossier['audience']) ?>
                <?php endif; ?>
            </p>
        </div>
        <?php if (isset($selectedDossier['illustration']) && is_string($selectedDossier['illustration'])): ?>
            <img src="<?= e($selectedDossier['illustration']) ?>" alt="">
        <?php endif; ?>
    </div>

    <?php if ($chapters !== []): ?>
        <nav class="chapter-nav" aria-label="Chapitres du dossier">
            <?php foreach ($chapters as $chapter): ?>
                <?php
                if (!is_array($chapter) || !isset($chapter['id'], $chapter['title']) || !is_string($chapter['id']) || !is_string($chapter['title'])) {
                    continue;
                }
                ?>
                <a href="?page=dossier&amp;dossier=<?= e($selectedDossier['id']) ?>&amp;chapitre=<?= e($chapter['id']) ?>"<?= $chapter['id'] === $currentChapterId ? ' aria-current="page"' : '' ?>>
                    <?= e($chapter['title']) ?>
                </a>
            <?php endforeach; ?>
        </nav>
    <?php endif; ?>

    <article class="card dossier-chapter">
        <h3><?= e($selectedDossierChapter['title']) ?></h3>
        <?php if (isset($selectedDossierChapter['summary']) && is_string($selectedDossierChapter['summary'])): ?>
            <p class="lead"><?= e($selectedDossierChapter['summary']) ?></p>
        <?php endif; ?>
        <?php if (is_array($selectedDossierChapter['paragraphs'] ?? null)): ?>
            <?php foreach ($selectedDossierChapter['paragraphs'] as $paragraph): ?>
                <?php if (is_string($paragraph) && trim($paragraph) !== ''): ?>
                    <p><?= e($paragraph) ?></p>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </article>

    <div class="resource-detail-grid">
        <?php if (is_array($selectedDossierChapter['key_points'] ?? null)): ?>
            <section class="card resource-detail-card">
                <h3>À retenir</h3>
                <ul class="list-tight">
                    <?php foreach ($selectedDossierChapter['key_points'] as $point): ?>
                        <?php if (is_string($point) && trim($point) !== ''): ?>
                            <li><?= e($point) ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </section>
        <?php endif; ?>

        <?php if (is_array($selectedDossierChapter['citizen_actions'] ?? null)): ?>
            <section class="card resource-detail-card">
                <h3>Actions citoyennes</h3>
                <ul class="list-tight">
                    <?php foreach ($selectedDossierChapter['citizen_actions'] as $action): ?>
                        <?php if (is_string($action) && trim($action) !== ''): ?>
                            <li><?= e($action) ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </section>
        <?php endif; ?>
    </div>

    <?php if ($references !== []): ?>
        <section class="card references-card" aria-labelledby="references-title">
            <h3 id="references-title">Références utiles</h3>
            <ul class="reference-list">
                <?php foreach ($references as $reference): ?>
                    <?php
                    if (!is_array($reference) || !isset($reference['label'], $reference['url']) || !is_string($reference['label']) || !is_string($reference['url'])) {
                        continue;
                    }
                    ?>
                    <li><a href="<?= e($reference['url']) ?>" rel="noopener noreferrer" target="_blank"><?= e($reference['label']) ?></a></li>
                <?php endforeach; ?>
            </ul>
        </section>
    <?php endif; ?>
</section>
