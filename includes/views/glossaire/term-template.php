<?php
if (!is_array($selectedGlossaryTerm)) {
    return;
}

$term = isset($selectedGlossaryTerm['term']) && is_string($selectedGlossaryTerm['term']) ? $selectedGlossaryTerm['term'] : 'Termes';
$definition = isset($selectedGlossaryTerm['definition']) && is_string($selectedGlossaryTerm['definition']) ? $selectedGlossaryTerm['definition'] : '';
$termSlug = glossarySlug($term);

$introduction = $glossaryIntroduction ?? (
    $definition !== ''
        ? $definition
        : "Ce terme sert a decrire un aspect precis des pratiques, des chaines de valeur ou de la gestion quotidienne de l'agriculture."
);

$whatToSee = $glossaryWhatToSee ?? [
    "Reperez ce terme dans les fiches techniques, les conseils de production et les echanges entre producteurs.",
    "Liez le vocabulaire a des exemples concrets du territoire (ferme, marche local, saisonnalite, filiere).",
    "Comparez les usages selon les echelles : exploitation, region, et politique agricole.",
];

$whyImportant = $glossaryWhyImportant ?? [
    "Permettre une meilleure comprehension des enjeux agricoles entre producteurs, transformateurs et citoyens.",
    "Evaluer l'impact d'un choix de production sur les couts, la qualite, la resilience et l'environnement.",
    "Favoriser des decisions d'achat et des choix de pratiques plus coherents.",
];

$actions = $glossaryActions ?? [
    "Identifier les situations locales ou le terme est mobilise.",
    "Verifier les criteres techniques cites dans les documents officiels ou les notices metier.",
    "Integrer une phrase claire dans vos explications ou dans vos fiches d'action citoyenne.",
];
?>

<section aria-labelledby="glossary-term-title" class="shadow-soft">
    <p><a href="?page=glossaire">Retour au glossaire</a></p>
    <h2 id="glossary-term-title"><?= e($term) ?></h2>

    <article class="card resource-summary">
        <p><?= e($introduction) ?></p>
    </article>

    <article class="card">
        <h3>Definition</h3>
        <p><?= e($definition) ?></p>
    </article>

    <div class="resource-detail-grid">
        <section class="card">
            <h3>Ce qu'il faut observer</h3>
            <ul class="list-tight">
                <?php foreach ($whatToSee as $line): ?>
                    <li><?= e($line) ?></li>
                <?php endforeach; ?>
            </ul>
        </section>

        <section class="card">
            <h3>Pourquoi c'est important</h3>
            <ul class="list-tight">
                <?php foreach ($whyImportant as $line): ?>
                    <li><?= e($line) ?></li>
                <?php endforeach; ?>
            </ul>
        </section>

        <section class="card">
            <h3>A appliquer</h3>
            <ul class="list-tight">
                <?php foreach ($actions as $line): ?>
                    <li><?= e($line) ?></li>
                <?php endforeach; ?>
            </ul>
        </section>
    </div>

    <p><a href="?page=glossaire&term=<?= e($termSlug) ?>">Voir ce terme dans la liste</a></p>
</section>
