<section aria-labelledby="glossary-title" class="shadow-soft">
    <h2 id="glossary-title">Glossaire</h2>
    <div class="grid grid-2">
        <?php foreach ($glossary as $entry): ?>
            <?php
            $glossaryText = mb_strtolower($entry['term'] . ' ' . $entry['definition']);
            if ($search !== '' && !str_contains($glossaryText, mb_strtolower($search))) {
                continue;
            }
            ?>
            <article class="card h-full">
                <h3><?= e($entry['term']) ?></h3>
                <p><?= e($entry['definition']) ?></p>
            </article>
        <?php endforeach; ?>
    </div>
</section>
