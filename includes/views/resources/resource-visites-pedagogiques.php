<?php
/** @var array<string, mixed> $selectedResource */

$continuousContent = isset($selectedResource['continuous_content']) && is_string($selectedResource['continuous_content'])
    ? trim($selectedResource['continuous_content'])
    : '';

$steps = is_array($selectedResource['steps'] ?? null) ? $selectedResource['steps'] : [];
$checklist = is_array($selectedResource['checklist'] ?? null) ? $selectedResource['checklist'] : [];
$objectives = is_array($selectedResource['learning_objectives'] ?? null) ? $selectedResource['learning_objectives'] : [];
$program = is_array($selectedResource['recommended_program'] ?? null) ? $selectedResource['recommended_program'] : [];
$ageAdaptations = is_array($selectedResource['age_adaptations'] ?? null) ? $selectedResource['age_adaptations'] : [];
$activities = is_array($selectedResource['pedagogical_activities'] ?? null) ? $selectedResource['pedagogical_activities'] : [];
$risks = is_array($selectedResource['risk_prevention'] ?? null) ? $selectedResource['risk_prevention'] : [];
$budget = is_array($selectedResource['budget_items'] ?? null) ? $selectedResource['budget_items'] : [];
$evaluation = is_array($selectedResource['evaluation_method'] ?? null) ? $selectedResource['evaluation_method'] : [];
$contacts = is_array($selectedResource['support_contacts'] ?? null) ? $selectedResource['support_contacts'] : [];
$blocks = is_array($selectedResource['content_blocks'] ?? null) ? $selectedResource['content_blocks'] : [];
?>

<section aria-labelledby="resource-title" class="shadow-soft">
    <p><a href="?page=ressources">← Retour aux ressources</a></p>
    <h2 id="resource-title"><?= e($selectedResource['title']) ?></h2>
    <p class="section-intro"><?= e($selectedResource['description']) ?></p>

    <article class="card resource-summary">
        <?php if (is_string($selectedResource['overview'] ?? null) && trim((string) $selectedResource['overview']) !== ''): ?>
            <h3>En bref</h3>
            <p><?= e($selectedResource['overview']) ?></p>
        <?php endif; ?>
        <?php if (is_string($selectedResource['for'] ?? null) && trim((string) $selectedResource['for']) !== ''): ?>
            <p><strong>Public cible :</strong> <?= e($selectedResource['for']) ?></p>
        <?php endif; ?>
    </article>

    <?php if ($continuousContent !== ''): ?>
        <article class="card">
            <h3>Contexte et objectif</h3>
            <?php foreach (splitTextIntoParagraphs($continuousContent) as $paragraph): ?>
                <p><?= e($paragraph) ?></p>
            <?php endforeach; ?>
        </article>
    <?php endif; ?>

    <?php if ($blocks !== []): ?>
        <article class="resource-detail-grid">
            <?php foreach ($blocks as $block): ?>
                <?php if (!is_array($block)) { continue; } ?>
                <?php
                $blockTitle = isset($block['title']) && is_string($block['title']) ? $block['title'] : '';
                $blockText = isset($block['text']) && is_string($block['text']) ? trim($block['text']) : '';
                $blockItems = isset($block['items']) && is_array($block['items']) ? $block['items'] : [];

                if ($blockTitle === '' && $blockText === '' && $blockItems === []) {
                    continue;
                }
                ?>
                <section class="card resource-detail-card">
                    <?php if ($blockTitle !== ''): ?>
                        <h3><?= e($blockTitle) ?></h3>
                    <?php endif; ?>
                    <?php if ($blockText !== ''): ?>
                        <?php foreach (splitTextIntoParagraphs($blockText) as $paragraph): ?>
                            <p><?= e($paragraph) ?></p>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <?php if ($blockItems !== []): ?>
                        <ul class="list-tight">
                            <?php foreach ($blockItems as $item): ?>
                                <?php if (is_string($item) && trim($item) !== ''): ?>
                                    <li><?= e($item) ?></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </section>
            <?php endforeach; ?>
        </article>
    <?php endif; ?>

    <?php if ($steps !== []): ?>
        <article class="card">
            <h3>Parcours recommande</h3>
            <ol class="list-tight">
                <?php foreach ($steps as $item): ?>
                    <?php if (is_string($item) && trim($item) !== ''): ?>
                        <li><?= e($item) ?></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ol>
        </article>
    <?php endif; ?>

    <?php if ($objectives !== [] || $program !== [] || $ageAdaptations !== [] || $activities !== [] || $risks !== [] || $budget !== [] || $evaluation !== [] || $checklist !== [] || $contacts !== []): ?>
        <article class="resource-detail-grid">
            <?php if ($checklist !== []): ?>
                <section class="card resource-detail-card">
                    <h3>Checklist de preparation</h3>
                    <ul class="list-tight">
                        <?php foreach ($checklist as $item): ?>
                            <?php if (is_string($item) && trim($item) !== ''): ?>
                                <li><?= e($item) ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endif; ?>

            <?php if ($objectives !== []): ?>
                <section class="card resource-detail-card">
                    <h3>Objectifs pedagogiques</h3>
                    <ul class="list-tight">
                        <?php foreach ($objectives as $item): ?>
                            <?php if (is_string($item) && trim($item) !== ''): ?>
                                <li><?= e($item) ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endif; ?>

            <?php if ($program !== []): ?>
                <section class="card resource-detail-card">
                    <h3>Programme type</h3>
                    <ul class="list-tight">
                        <?php foreach ($program as $item): ?>
                            <?php if (is_string($item) && trim($item) !== ''): ?>
                                <li><?= e($item) ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endif; ?>

            <?php if ($ageAdaptations !== []): ?>
                <section class="card resource-detail-card">
                    <h3>Adaptation selon l'age</h3>
                    <ul class="list-tight">
                        <?php foreach ($ageAdaptations as $item): ?>
                            <?php if (is_string($item) && trim($item) !== ''): ?>
                                <li><?= e($item) ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endif; ?>

            <?php if ($activities !== []): ?>
                <section class="card resource-detail-card">
                    <h3>Activites pedagogiques</h3>
                    <ul class="list-tight">
                        <?php foreach ($activities as $item): ?>
                            <?php if (is_string($item) && trim($item) !== ''): ?>
                                <li><?= e($item) ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endif; ?>

            <?php if ($risks !== []): ?>
                <section class="card resource-detail-card">
                    <h3>Risque et securite</h3>
                    <ul class="list-tight">
                        <?php foreach ($risks as $item): ?>
                            <?php if (is_string($item) && trim($item) !== ''): ?>
                                <li><?= e($item) ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endif; ?>

            <?php if ($budget !== []): ?>
                <section class="card resource-detail-card">
                    <h3>Budget previsionnel</h3>
                    <ul class="list-tight">
                        <?php foreach ($budget as $item): ?>
                            <?php if (is_string($item) && trim($item) !== ''): ?>
                                <li><?= e($item) ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endif; ?>

            <?php if ($evaluation !== []): ?>
                <section class="card resource-detail-card">
                    <h3>Evaluation</h3>
                    <ul class="list-tight">
                        <?php foreach ($evaluation as $item): ?>
                            <?php if (is_string($item) && trim($item) !== ''): ?>
                                <li><?= e($item) ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endif; ?>

            <?php if ($contacts !== []): ?>
                <section class="card resource-detail-card">
                    <h3>Qui peut accompagner</h3>
                    <ul class="list-tight">
                        <?php foreach ($contacts as $item): ?>
                            <?php if (is_string($item) && trim($item) !== ''): ?>
                                <li><?= e($item) ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endif; ?>
        </article>
    <?php endif; ?>

    <?php require __DIR__ . '/../../partials/resource-verification.php'; ?>
</section>
