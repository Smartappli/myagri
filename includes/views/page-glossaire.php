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
        <p><a href="<?= e(localizedUrl(['page' => 'glossaire'])) ?>"><?= e(t('glossary.back')) ?></a></p>
        <h2 id="glossary-title"><?= e($selectedTerm) ?></h2>
        <article class="card resource-summary">
            <p><?= e($selectedDefinition) ?></p>
            <?php if ($selectedSlug !== ''): ?>
                <p><a href="<?= e(localizedUrl(['page' => 'glossaire', 'term' => $selectedSlug])) ?>"><?= e(t('glossary.back_detail')) ?></a></p>
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
    <h2 id="glossary-title"><?= e(t('glossary.title')) ?></h2>
    <p class="section-intro"><?= e(t('glossary.intro', ['count' => count($glossary)])) ?></p>
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
                <p><a href="<?= e(localizedUrl(['page' => 'glossaire', 'term' => $termSlug])) ?>"><?= e(t('glossary.detail_link')) ?></a></p>
            </article>
        <?php endforeach; ?>
    </div>
</section>
