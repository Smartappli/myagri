<?php
$termTemplate = null;
if (is_array($selectedGlossaryTerm)) {
    $selectedTerm = $selectedGlossaryTerm['term'];
    if (is_string($selectedTerm) && $selectedTerm !== '') {
        $selectedTermSlug = glossaryEntrySlug($selectedGlossaryTerm);
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
    $selectedSlug = glossaryEntrySlug($selectedGlossaryTerm);
    ?>
    <section aria-labelledby="glossary-title" class="shadow-soft">
        <p><a href="?page=glossaire">Zurück zum Glossar</a></p>
        <h2 id="glossary-title"><?= e($selectedTerm) ?></h2>
        <article class="card resource-summary">
            <p><?= e($selectedDefinition) ?></p>
            <?php if ($selectedSlug !== ''): ?>
                <p><a href="?page=glossaire&amp;term=<?= e($selectedSlug) ?>">Zur Detailseite zurück</a></p>
            <?php endif; ?>
        </article>
    </section>
    <?php
    return;
}

$sortedGlossary = $glossary;
usort($sortedGlossary, static function (array $left, array $right): int {
    $leftTerm = isset($left['term']) && is_string($left['term']) ? $left['term'] : '';
    $rightTerm = isset($right['term']) && is_string($right['term']) ? $right['term'] : '';

    return glossaryEntrySlug($left) <=> glossaryEntrySlug($right);
});
?>

<section aria-labelledby="glossary-title" class="shadow-soft">
    <h2 id="glossary-title">Glossar</h2>
    <p class="section-intro">Ein Verzeichnis mit <?= count($glossary) ?> Begriffen zu Agrarsektoren, Praxis auf dem Feld, öffentlichen Politiken, regionaler Ernährung und agroökologischem Wandel.</p>
    <div class="grid grid-2">
        <?php foreach ($sortedGlossary as $entry): ?>
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

            $termSlug = glossaryEntrySlug($entry);
            ?>
            <article class="card h-full">
                <h3><?= e($term) ?></h3>
                <p><?= e($definition) ?></p>
                <p><a href="?page=glossaire&amp;term=<?= e($termSlug) ?>">Detailseite ansehen</a></p>
            </article>
        <?php endforeach; ?>
    </div>
</section>
