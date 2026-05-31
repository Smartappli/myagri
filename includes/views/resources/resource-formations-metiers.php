<?php
/** @var array<string, mixed> $selectedResource */

$continuousContent = isset($selectedResource['continuous_content']) && is_string($selectedResource['continuous_content'])
    ? trim($selectedResource['continuous_content'])
    : '';

$steps = is_array($selectedResource['steps'] ?? null) ? $selectedResource['steps'] : [];
$checklist = is_array($selectedResource['checklist'] ?? null) ? $selectedResource['checklist'] : [];
$jobFamilies = is_array($selectedResource['job_families'] ?? null) ? $selectedResource['job_families'] : [];
$trainingPaths = is_array($selectedResource['training_paths'] ?? null) ? $selectedResource['training_paths'] : [];
$keySkills = is_array($selectedResource['key_skills'] ?? null) ? $selectedResource['key_skills'] : [];
$certifications = is_array($selectedResource['certifications'] ?? null) ? $selectedResource['certifications'] : [];
$financing = is_array($selectedResource['financing_options'] ?? null) ? $selectedResource['financing_options'] : [];
$applicationTips = is_array($selectedResource['application_tips'] ?? null) ? $selectedResource['application_tips'] : [];
$salaryFactors = is_array($selectedResource['salary_factors'] ?? null) ? $selectedResource['salary_factors'] : [];
$mobilityPaths = is_array($selectedResource['mobility_paths'] ?? null) ? $selectedResource['mobility_paths'] : [];
$actionPlan = is_array($selectedResource['action_plan_90_days'] ?? null) ? $selectedResource['action_plan_90_days'] : [];
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
            <h3>Parcours d'orientation</h3>
            <ol class="list-tight">
                <?php foreach ($steps as $item): ?>
                    <?php if (is_string($item) && trim($item) !== ''): ?>
                        <li><?= e($item) ?></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ol>
        </article>
    <?php endif; ?>

    <?php if ($checklist !== [] || $jobFamilies !== [] || $trainingPaths !== [] || $keySkills !== [] || $certifications !== [] || $financing !== [] || $applicationTips !== [] || $salaryFactors !== [] || $mobilityPaths !== [] || $actionPlan !== []): ?>
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

            <?php if ($jobFamilies !== []): ?>
                <section class="card resource-detail-card">
                    <h3>Familles de metiers</h3>
                    <ul class="list-tight">
                        <?php foreach ($jobFamilies as $item): ?>
                            <?php if (is_string($item) && trim($item) !== ''): ?>
                                <li><?= e($item) ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endif; ?>

            <?php if ($trainingPaths !== []): ?>
                <section class="card resource-detail-card">
                    <h3>Parcours de formation</h3>
                    <ul class="list-tight">
                        <?php foreach ($trainingPaths as $item): ?>
                            <?php if (is_string($item) && trim($item) !== ''): ?>
                                <li><?= e($item) ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endif; ?>

            <?php if ($keySkills !== []): ?>
                <section class="card resource-detail-card">
                    <h3>Competences cles</h3>
                    <ul class="list-tight">
                        <?php foreach ($keySkills as $item): ?>
                            <?php if (is_string($item) && trim($item) !== ''): ?>
                                <li><?= e($item) ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endif; ?>

            <?php if ($certifications !== []): ?>
                <section class="card resource-detail-card">
                    <h3>Certifications</h3>
                    <ul class="list-tight">
                        <?php foreach ($certifications as $item): ?>
                            <?php if (is_string($item) && trim($item) !== ''): ?>
                                <li><?= e($item) ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endif; ?>

            <?php if ($financing !== []): ?>
                <section class="card resource-detail-card">
                    <h3>Financements</h3>
                    <ul class="list-tight">
                        <?php foreach ($financing as $item): ?>
                            <?php if (is_string($item) && trim($item) !== ''): ?>
                                <li><?= e($item) ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endif; ?>

            <?php if ($applicationTips !== []): ?>
                <section class="card resource-detail-card">
                    <h3>Conseils de candidature</h3>
                    <ul class="list-tight">
                        <?php foreach ($applicationTips as $item): ?>
                            <?php if (is_string($item) && trim($item) !== ''): ?>
                                <li><?= e($item) ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endif; ?>

            <?php if ($salaryFactors !== []): ?>
                <section class="card resource-detail-card">
                    <h3>Facteurs de remuneration</h3>
                    <ul class="list-tight">
                        <?php foreach ($salaryFactors as $item): ?>
                            <?php if (is_string($item) && trim($item) !== ''): ?>
                                <li><?= e($item) ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endif; ?>

            <?php if ($mobilityPaths !== []): ?>
                <section class="card resource-detail-card">
                    <h3>Evolutions possibles</h3>
                    <ul class="list-tight">
                        <?php foreach ($mobilityPaths as $item): ?>
                            <?php if (is_string($item) && trim($item) !== ''): ?>
                                <li><?= e($item) ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endif; ?>

            <?php if ($actionPlan !== []): ?>
                <section class="card resource-detail-card">
                    <h3>Plan d'action 90 jours</h3>
                    <ul class="list-tight">
                        <?php foreach ($actionPlan as $item): ?>
                            <?php if (is_string($item) && trim($item) !== ''): ?>
                                <li><?= e($item) ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endif; ?>
        </article>
    <?php endif; ?>
</section>
