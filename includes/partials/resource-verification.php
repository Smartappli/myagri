<?php
/**
 * @var array<string, mixed> $selectedResource
 */

$resourceTitle = isset($selectedResource['title']) && is_string($selectedResource['title'])
    ? trim($selectedResource['title'])
    : t('resources.default_resource');

$verificationPrompts = is_array($selectedResource['verification_prompts'] ?? null)
    ? $selectedResource['verification_prompts']
    : [
        t('resources.verification_prompt_information'),
        t('resources.verification_prompt_criterion'),
        t('resources.verification_prompt_limit'),
    ];
?>

<article class="card resource-verification">
    <h3><?= e(t('resources.verification_title')) ?></h3>
    <p><?= e(t('resources.verification_text', ['resource' => $resourceTitle])) ?></p>
    <ul class="list-tight">
        <?php foreach ($verificationPrompts as $prompt): ?>
            <?php if (is_string($prompt) && trim($prompt) !== ''): ?>
                <li><?= e($prompt) ?></li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</article>
