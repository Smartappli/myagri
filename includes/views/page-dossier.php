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
$renderList = static function (array $items, bool $ordered = false): void {
    $tag = $ordered ? 'ol' : 'ul';
    ?>
    <<?= $tag ?> class="list-tight">
        <?php foreach ($items as $item): ?>
            <?php if (is_string($item) && trim($item) !== ''): ?>
                <li><?= e($item) ?></li>
            <?php endif; ?>
        <?php endforeach; ?>
    </<?= $tag ?>>
    <?php
};
$renderCard = static function (string $title, array $items, bool $ordered = false) use ($renderList): void {
    if ($items === []) {
        return;
    }
    ?>
    <section class="card resource-detail-card">
        <h3><?= e($title) ?></h3>
        <?php $renderList($items, $ordered); ?>
    </section>
    <?php
};
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
            <figure class="dossier-hero-media">
                <img src="<?= e($selectedDossier['illustration']) ?>" alt="<?= e(isset($selectedDossier['illustration_alt']) && is_string($selectedDossier['illustration_alt']) ? $selectedDossier['illustration_alt'] : $selectedDossier['title']) ?>">
            </figure>
        <?php endif; ?>
    </div>

    <div class="pedagogical-overview">
        <?php if (is_array($selectedDossier['learning_objectives'] ?? null)): ?>
            <?php $renderCard('Objectifs pédagogiques', $selectedDossier['learning_objectives']); ?>
        <?php endif; ?>
        <?php if (is_array($selectedDossier['pedagogical_use'] ?? null)): ?>
            <?php $renderCard('Mode d’emploi du dossier', $selectedDossier['pedagogical_use'], true); ?>
        <?php endif; ?>
        <?php if (is_array($selectedDossier['activity_kit'] ?? null)): ?>
            <?php $renderCard('Matériel conseillé', $selectedDossier['activity_kit']); ?>
        <?php endif; ?>
        <?php if (is_array($selectedDossier['evaluation'] ?? null)): ?>
            <?php $renderCard('Évaluer la compréhension', $selectedDossier['evaluation']); ?>
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

        <?php if (is_array($selectedDossierChapter['pedagogical_sequence'] ?? null)): ?>
            <div class="chapter-section">
                <h4>Déroulé pédagogique</h4>
                <?php $renderList($selectedDossierChapter['pedagogical_sequence'], true); ?>
            </div>
        <?php endif; ?>

        <?php if (is_array($selectedDossierChapter['workshop'] ?? null)): ?>
            <?php $workshop = $selectedDossierChapter['workshop']; ?>
            <aside class="chapter-workshop">
                <p class="eyebrow">Activité guidée</p>
                <?php if (isset($workshop['title']) && is_string($workshop['title'])): ?>
                    <h4><?= e($workshop['title']) ?></h4>
                <?php endif; ?>
                <?php if (isset($workshop['duration']) && is_string($workshop['duration'])): ?>
                    <p class="meta"><?= e($workshop['duration']) ?></p>
                <?php endif; ?>
                <?php if (isset($workshop['objective']) && is_string($workshop['objective'])): ?>
                    <p><?= e($workshop['objective']) ?></p>
                <?php endif; ?>
                <?php if (is_array($workshop['steps'] ?? null)): ?>
                    <?php $renderList($workshop['steps'], true); ?>
                <?php endif; ?>
                <?php if (isset($workshop['debrief']) && is_string($workshop['debrief'])): ?>
                    <p><strong>Synthèse :</strong> <?= e($workshop['debrief']) ?></p>
                <?php endif; ?>
            </aside>
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

        <?php if (is_array($selectedDossierChapter['discussion_questions'] ?? null)): ?>
            <section class="card resource-detail-card">
                <h3>Questions pour débattre</h3>
                <?php $renderList($selectedDossierChapter['discussion_questions']); ?>
            </section>
        <?php endif; ?>

        <?php if (is_array($selectedDossierChapter['teacher_notes'] ?? null)): ?>
            <section class="card resource-detail-card">
                <h3>Repères d’animation</h3>
                <?php $renderList($selectedDossierChapter['teacher_notes']); ?>
            </section>
        <?php endif; ?>
    </div>

    <?php if (is_array($selectedDossier['vocabulary'] ?? null)): ?>
        <section class="card dossier-vocabulary" aria-labelledby="dossier-vocabulary-title">
            <h3 id="dossier-vocabulary-title">Lexique lié au dossier</h3>
            <div class="vocabulary-links">
                <?php foreach ($selectedDossier['vocabulary'] as $term): ?>
                    <?php if (is_string($term) && trim($term) !== ''): ?>
                        <a href="?page=glossaire&amp;term=<?= e(glossarySlug($term)) ?>"><?= e($term) ?></a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

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
