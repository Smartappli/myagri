<?php
/**
 * @var array<string, mixed> $selectedResource
 */

$resourceTitle = isset($selectedResource['title']) && is_string($selectedResource['title'])
    ? trim($selectedResource['title'])
    : 'cette ressource';

$verificationPrompts = is_array($selectedResource['verification_prompts'] ?? null)
    ? $selectedResource['verification_prompts']
    : [
        'Quelle information doit être confirmée auprès d’un guichet, d’un producteur, d’une commune ou d’un organisme compétent ?',
        'Quel critère permet de vérifier l’effet annoncé : coût, temps, origine, volume, saison, sécurité, revenu ou impact environnemental ?',
        'Quelle limite faut-il mentionner pour éviter de transformer un conseil utile en règle valable partout ?',
    ];
?>

<article class="card resource-verification">
    <h3>À vérifier avant d’agir</h3>
    <p><?= e($resourceTitle) ?> donne des repères pratiques. Avant une décision engageante, gardez une trace des sources, des coûts, des contraintes locales et des personnes consultées.</p>
    <ul class="list-tight">
        <?php foreach ($verificationPrompts as $prompt): ?>
            <?php if (is_string($prompt) && trim($prompt) !== ''): ?>
                <li><?= e($prompt) ?></li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</article>
