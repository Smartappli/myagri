<?php
$termTemplate = null;
if (is_array($selectedGlossaryTerm)) {
    $selectedTerm = $selectedGlossaryTerm['term'];
    if (is_string($selectedTerm) && $selectedTerm !== '') {
        $selectedTermSlug = glossarySlug($selectedTerm);
        $termTemplate = glossaryTemplatePath($selectedTermSlug);
    }
}

if ($termTemplate !== null) {
    require $termTemplate;
    return;
}

if (is_array($selectedGlossaryTerm)) {
    $selectedTerm = isset($selectedGlossaryTerm['term']) && is_string($selectedGlossaryTerm['term']) ? $selectedGlossaryTerm['term'] : '';
    $selectedDefinition = isset($selectedGlossaryTerm['definition']) && is_string($selectedGlossaryTerm['definition']) ? $selectedGlossaryTerm['definition'] : '';
    $selectedSlug = isset($selectedGlossaryTerm['term']) && is_string($selectedGlossaryTerm['term']) ? glossarySlug($selectedGlossaryTerm['term']) : '';
    ?>
    <section aria-labelledby="glossary-title" class="shadow-soft">
        <p><a href="?page=glossaire">← Retour au glossaire</a></p>
        <h2 id="glossary-title"><?= e($selectedTerm) ?></h2>
        <article class="card resource-summary">
            <p><?= e($selectedDefinition) ?></p>
            <?php if ($selectedSlug !== ''): ?>
                <p><a href="?page=glossaire&amp;term=<?= e($selectedSlug) ?>">Retour à la fiche dédiée</a></p>
            <?php endif; ?>
        </article>
    </section>
    <?php
    return;
}
?>

<section aria-labelledby="glossary-title" class="shadow-soft">
    <h2 id="glossary-title">Glossaire</h2>
    <div class="grid grid-2">
        <?php foreach ($glossary as $entry): ?>
            <?php
            $term = isset($entry['term']) && is_string($entry['term']) ? $entry['term'] : '';
            $definition = isset($entry['definition']) && is_string($entry['definition']) ? $entry['definition'] : '';
            if ($term === '') {
                continue;
            }

            $glossaryText = mb_strtolower($term . ' ' . $definition);
            if ($search !== '' && !str_contains($glossaryText, mb_strtolower($search))) {
                continue;
            }

            $termSlug = glossarySlug($term);
            ?>
            <article class="card h-full">
                <h3><?= e($term) ?></h3>
                <p><?= e($definition) ?></p>
                <p><a href="?page=glossaire&amp;term=<?= e($termSlug) ?>">Voir la page détaillée</a></p>
            </article>
        <?php endforeach; ?>
    </div>
</section>
