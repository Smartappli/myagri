<section aria-labelledby="resources-title" class="shadow-soft">
    <h2 id="resources-title">Nützliche Ressourcen</h2>
    <p class="section-intro">Praktische Leitfäden, um von der Absicht ins Handeln zu kommen: Besuch organisieren, Labels vergleichen, besser einkaufen, Berufe entdecken oder ein Begleitdossier vorbereiten.</p>
    <div class="grid grid-3">
        <?php foreach ($resources as $resource): ?>
            <?php
            $resourceText = mb_strtolower($resource['title'] . ' ' . $resource['description'] . ' ' . ($resource['overview'] ?? '') . ' ' . ($resource['for'] ?? ''));
            if ($search !== '' && !str_contains($resourceText, mb_strtolower($search))) {
                continue;
            }
            ?>
            <article class="card h-full resource-card">
                <h3><?= e($resource['title']) ?></h3>
                <p><?= e($resource['description']) ?></p>
                <?php if (isset($resource['overview']) && is_string($resource['overview']) && $resource['overview'] !== ''): ?>
                    <p class="resource-overview"><?= e($resource['overview']) ?></p>
                <?php endif; ?>
                <?php if (isset($resource['for']) && is_string($resource['for']) && $resource['for'] !== ''): ?>
                    <p class="tagline"><strong>Für:</strong> <?= e($resource['for']) ?></p>
                <?php endif; ?>
                <?php if (isset($resource['id']) && is_string($resource['id'])): ?>
                    <p class="card-action"><a class="button-link" href="?page=ressource&amp;resource=<?= e($resource['id']) ?>">Detailseite ansehen</a></p>
                <?php endif; ?>
            </article>
        <?php endforeach; ?>
    </div>
</section>
