<?php
/** @var array<string, mixed> $selectedResource */

$continuousContent = isset($selectedResource['continuous_content']) && is_string($selectedResource['continuous_content'])
    ? trim($selectedResource['continuous_content'])
    : '';

$steps = is_array($selectedResource['steps'] ?? null) ? $selectedResource['steps'] : [];
$checklist = is_array($selectedResource['checklist'] ?? null) ? $selectedResource['checklist'] : [];
$eligibleProjects = is_array($selectedResource['eligible_projects'] ?? null) ? $selectedResource['eligible_projects'] : [];
$requiredDocuments = is_array($selectedResource['required_documents'] ?? null) ? $selectedResource['required_documents'] : [];
$timeline = is_array($selectedResource['timeline'] ?? null) ? $selectedResource['timeline'] : [];
$commonPitfalls = is_array($selectedResource['common_pitfalls'] ?? null) ? $selectedResource['common_pitfalls'] : [];
$supportContacts = is_array($selectedResource['support_contacts'] ?? null) ? $selectedResource['support_contacts'] : [];
?>

<section aria-labelledby="resource-title" class="shadow-soft">
    <p><a href="?page=ressources">&#8592; Retour aux ressources</a></p>
    <h2 id="resource-title"><?= e($selectedResource['title']) ?></h2>
    <p class="section-intro"><?= e($selectedResource['description']) ?></p>

    <article class="card resource-summary">
        <?php if (is_string($selectedResource['overview'] ?? null) && trim((string) $selectedResource['overview']) !== ''): ?>
            <h3>En bref</h3>
            <p><?= e($selectedResource['overview']) ?></p>
        <?php endif; ?>
        <?php if (is_string($selectedResource['for'] ?? null) && trim((string) $selectedResource['for']) !== ''): ?>
            <p><strong>Public concerne :</strong> <?= e($selectedResource['for']) ?></p>
        <?php endif; ?>
    </article>

    <?php if ($continuousContent !== ''): ?>
        <article class="card">
            <h3>Contexte</h3>
            <?php foreach (splitTextIntoParagraphs($continuousContent) as $paragraph): ?>
                <p><?= e($paragraph) ?></p>
            <?php endforeach; ?>
        </article>
    <?php endif; ?>

    <?php if ($steps !== []): ?>
        <article class="card">
            <h3>Parcours de demarche</h3>
            <ol class="list-tight">
                <?php foreach ($steps as $item): ?>
                    <?php if (is_string($item) && trim($item) !== ''): ?>
                        <li><?= e($item) ?></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ol>
        </article>
    <?php endif; ?>

    <?php if ($checklist !== [] || $eligibleProjects !== [] || $requiredDocuments !== [] || $timeline !== [] || $commonPitfalls !== [] || $supportContacts !== []): ?>
        <article class="resource-detail-grid">
            <?php if ($checklist !== []): ?>
                <section class="card resource-detail-card">
                    <h3>Checklist</h3>
                    <ul class="list-tight">
                        <?php foreach ($checklist as $item): ?>
                            <?php if (is_string($item) && trim($item) !== ''): ?>
                                <li><?= e($item) ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endif; ?>

            <?php if ($eligibleProjects !== []): ?>
                <section class="card resource-detail-card">
                    <h3>Projets elegibles</h3>
                    <ul class="list-tight">
                        <?php foreach ($eligibleProjects as $item): ?>
                            <?php if (is_string($item) && trim($item) !== ''): ?>
                                <li><?= e($item) ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endif; ?>

            <?php if ($requiredDocuments !== []): ?>
                <section class="card resource-detail-card">
                    <h3>Documents demandes</h3>
                    <ul class="list-tight">
                        <?php foreach ($requiredDocuments as $item): ?>
                            <?php if (is_string($item) && trim($item) !== ''): ?>
                                <li><?= e($item) ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endif; ?>

            <?php if ($timeline !== []): ?>
                <section class="card resource-detail-card">
                    <h3>Chronologie indicative</h3>
                    <ul class="list-tight">
                        <?php foreach ($timeline as $item): ?>
                            <?php if (is_string($item) && trim($item) !== ''): ?>
                                <li><?= e($item) ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endif; ?>

            <?php if ($commonPitfalls !== []): ?>
                <section class="card resource-detail-card">
                    <h3>Ecueils a eviter</h3>
                    <ul class="list-tight">
                        <?php foreach ($commonPitfalls as $item): ?>
                            <?php if (is_string($item) && trim($item) !== ''): ?>
                                <li><?= e($item) ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endif; ?>

            <?php if ($supportContacts !== []): ?>
                <section class="card resource-detail-card">
                    <h3>Qui peut accompagner</h3>
                    <ul class="list-tight">
                        <?php foreach ($supportContacts as $item): ?>
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
