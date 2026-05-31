<section aria-labelledby="resources-title" class="shadow-soft">
    <h2 id="resources-title">Ressources utiles</h2>
    <div class="grid grid-3">
        <?php foreach ($resources as $resource): ?>
            <?php
            $resourceText = mb_strtolower($resource['title'] . ' ' . $resource['description'] . ' ' . ($resource['overview'] ?? '') . ' ' . ($resource['for'] ?? ''));
            if ($search !== '' && !str_contains($resourceText, mb_strtolower($search))) {
                continue;
            }
            ?>
            <article class="card h-full">
                <h3><?= e($resource['title']) ?></h3>
                <p><?= e($resource['description']) ?></p>
                <?php if (isset($resource['id']) && is_string($resource['id'])): ?>
                    <p><a href="?page=ressource&amp;resource=<?= e($resource['id']) ?>">Voir la page détaillée</a></p>
                <?php endif; ?>
            </article>
        <?php endforeach; ?>
    </div>
</section>
