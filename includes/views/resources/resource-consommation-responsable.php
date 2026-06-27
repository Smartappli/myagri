<?php
/** @var array<string, mixed> $selectedResource */

$continuousContent = isset($selectedResource['continuous_content']) && is_string($selectedResource['continuous_content'])
    ? trim($selectedResource['continuous_content'])
    : '';

$steps = is_array($selectedResource['steps'] ?? null) ? $selectedResource['steps'] : [];
$checklist = is_array($selectedResource['checklist'] ?? null) ? $selectedResource['checklist'] : [];
$purchaseStrategy = is_array($selectedResource['purchase_strategy'] ?? null) ? $selectedResource['purchase_strategy'] : [];
$labelReading = is_array($selectedResource['label_reading'] ?? null) ? $selectedResource['label_reading'] : [];
$seasonalPlanning = is_array($selectedResource['seasonal_planning'] ?? null) ? $selectedResource['seasonal_planning'] : [];
$antiWaste = is_array($selectedResource['anti_waste_playbook'] ?? null) ? $selectedResource['anti_waste_playbook'] : [];
$nutrition = is_array($selectedResource['nutrition_balance'] ?? null) ? $selectedResource['nutrition_balance'] : [];
$budget = is_array($selectedResource['budget_optimisation'] ?? null) ? $selectedResource['budget_optimisation'] : [];
$kpi = is_array($selectedResource['kpi_tracking'] ?? null) ? $selectedResource['kpi_tracking'] : [];
?>

<section aria-labelledby="resource-title" class="shadow-soft">
    <p><a href="?page=ressources">&#8592; Zurück zu den Ressourcen</a></p>
    <h2 id="resource-title"><?= e($selectedResource['title']) ?></h2>
    <p class="section-intro"><?= e($selectedResource['description']) ?></p>

    <article class="card resource-summary">
        <?php if (is_string($selectedResource['overview'] ?? null) && trim((string) $selectedResource['overview']) !== ''): ?>
            <h3>Kurz gesagt</h3>
            <p><?= e($selectedResource['overview']) ?></p>
        <?php endif; ?>
        <?php if (is_string($selectedResource['for'] ?? null) && trim((string) $selectedResource['for']) !== ''): ?>
            <p><strong>Zielgruppe:</strong> <?= e($selectedResource['for']) ?></p>
        <?php endif; ?>
    </article>

    <?php if ($continuousContent !== ''): ?>
        <article class="card">
            <h3>Kontext</h3>
            <?php foreach (splitTextIntoParagraphs($continuousContent) as $paragraph): ?>
                <p><?= e($paragraph) ?></p>
            <?php endforeach; ?>
        </article>
    <?php endif; ?>

    <?php if ($steps !== []): ?>
        <article class="card">
            <h3>Handlungsweg</h3>
            <ol class="list-tight">
                <?php foreach ($steps as $item): ?>
                    <?php if (is_string($item) && trim($item) !== ''): ?>
                        <li><?= e($item) ?></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ol>
        </article>
    <?php endif; ?>

    <?php if ($checklist !== [] || $purchaseStrategy !== [] || $labelReading !== [] || $seasonalPlanning !== [] || $antiWaste !== [] || $nutrition !== [] || $budget !== [] || $kpi !== []): ?>
        <article class="resource-detail-grid">
            <?php if ($checklist !== []): ?>
                <section class="card resource-detail-card">
                    <h3>Checkliste</h3>
                    <ul class="list-tight">
                        <?php foreach ($checklist as $item): ?>
                            <?php if (is_string($item) && trim($item) !== ''): ?>
                                <li><?= e($item) ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endif; ?>

            <?php if ($purchaseStrategy !== []): ?>
                <section class="card resource-detail-card">
                    <h3>Einkaufsstrategie</h3>
                    <ul class="list-tight">
                        <?php foreach ($purchaseStrategy as $item): ?>
                            <?php if (is_string($item) && trim($item) !== ''): ?>
                                <li><?= e($item) ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endif; ?>

            <?php if ($labelReading !== []): ?>
                <section class="card resource-detail-card">
                    <h3>Labels lesen</h3>
                    <ul class="list-tight">
                        <?php foreach ($labelReading as $item): ?>
                            <?php if (is_string($item) && trim($item) !== ''): ?>
                                <li><?= e($item) ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endif; ?>

            <?php if ($seasonalPlanning !== []): ?>
                <section class="card resource-detail-card">
                    <h3>Saisonplanung</h3>
                    <ul class="list-tight">
                        <?php foreach ($seasonalPlanning as $item): ?>
                            <?php if (is_string($item) && trim($item) !== ''): ?>
                                <li><?= e($item) ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endif; ?>

            <?php if ($antiWaste !== []): ?>
                <section class="card resource-detail-card">
                    <h3>Anti-Verschwendungsleitfaden</h3>
                    <ul class="list-tight">
                        <?php foreach ($antiWaste as $item): ?>
                            <?php if (is_string($item) && trim($item) !== ''): ?>
                                <li><?= e($item) ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endif; ?>

            <?php if ($nutrition !== []): ?>
                <section class="card resource-detail-card">
                    <h3>Ernährungsbalance</h3>
                    <ul class="list-tight">
                        <?php foreach ($nutrition as $item): ?>
                            <?php if (is_string($item) && trim($item) !== ''): ?>
                                <li><?= e($item) ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endif; ?>

            <?php if ($budget !== []): ?>
                <section class="card resource-detail-card">
                    <h3>Budgetoptimierung</h3>
                    <ul class="list-tight">
                        <?php foreach ($budget as $item): ?>
                            <?php if (is_string($item) && trim($item) !== ''): ?>
                                <li><?= e($item) ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endif; ?>

            <?php if ($kpi !== []): ?>
                <section class="card resource-detail-card">
                    <h3>Monitoring und Kennzahlen</h3>
                    <ul class="list-tight">
                        <?php foreach ($kpi as $item): ?>
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
