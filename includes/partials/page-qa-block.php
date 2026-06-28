<?php
/**
 * @var array<int, array<string, mixed>> $faqPairs
 * @var string $qaTitle
 * @var string $qaIntro
 */
if ($faqPairs === []) {
    return;
}

$escapedTitle = $qaTitle !== '' ? $qaTitle : t('qa.default_title');
$escapedIntro = $qaIntro;
?>

<section class="shadow-soft" aria-labelledby="page-qa-title">
    <h2 id="page-qa-title"><?= e($escapedTitle) ?></h2>
    <?php if ($escapedIntro !== ''): ?>
        <p class="section-intro"><?= e($escapedIntro) ?></p>
    <?php endif; ?>

    <div class="resource-detail-grid">
        <?php foreach ($faqPairs as $pair): ?>
            <?php if (!isset($pair['question'], $pair['answer']) || !is_string($pair['question']) || !is_string($pair['answer'])) {
                continue;
            } ?>
            <article class="card resource-detail-card">
                <h3><?= e($pair['question']) ?></h3>
                <p><?= e($pair['answer']) ?></p>
            </article>
        <?php endforeach; ?>
    </div>
</section>
