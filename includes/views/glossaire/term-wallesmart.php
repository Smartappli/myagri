<?php
if (!is_array($selectedGlossaryTerm)) {
    $selectedGlossaryTerm = glossaryTermBySlug($glossary, 'wallesmart');
}

if (!is_array($selectedGlossaryTerm)) {
    return;
}

$term = isset($selectedGlossaryTerm['term']) && is_string($selectedGlossaryTerm['term']) ? $selectedGlossaryTerm['term'] : 'WALLeSmart';
$definition = isset($selectedGlossaryTerm['definition']) && is_string($selectedGlossaryTerm['definition'])
    ? $selectedGlossaryTerm['definition']
    : 'Plateforme numérique wallonne qui facilite l’échange sécurisé de données agricoles entre outils, agriculteurs et partenaires autorisés.';

$problems = [
    'Les données de ferme sont souvent réparties entre plusieurs logiciels, portails, capteurs et organismes.',
    'Les agriculteurs peuvent perdre du temps à se connecter à plusieurs services ou à encoder plusieurs fois une même information.',
    'Les applications agricoles ne se comprennent pas toujours entre elles : formats, référentiels et droits d’accès peuvent varier.',
    'La valeur d’une donnée agricole dépend aussi de sa gouvernance : qui y accède, pour quel usage, avec quel consentement et quelle traçabilité.',
];

$howItWorks = [
    'Interopérabilité : la plateforme cherche à faire circuler les données entre outils compatibles plutôt qu’à enfermer chaque service dans son propre silo.',
    'Accès simplifié : WALLeSmart met en avant un guichet d’accès sécurisé pour retrouver des applications et services agricoles partenaires.',
    'Tableau de bord : l’objectif est de donner une vue synthétique de certaines informations utiles à l’exploitation, sans remplacer les outils métier détaillés.',
    'Gestion des consentements : le partage de données doit rester lié à l’accord de l’utilisateur et aux règles prévues par les services concernés.',
];

$uses = [
    'Pour une ferme : réduire les doubles encodages, retrouver plus facilement des indicateurs et garder la main sur les autorisations de partage.',
    'Pour un conseiller ou un organisme technique : travailler avec des données mieux structurées, à condition que l’accès soit justifié et accepté.',
    'Pour un développeur d’outil agricole : s’appuyer sur une infrastructure et des référentiels communs au lieu de recréer seul chaque connexion.',
    'Pour un enseignant ou un citoyen : comprendre que le numérique agricole n’est pas seulement une application, mais aussi une question de confiance, de standards et de gouvernance.',
];

$watchPoints = [
    'Ne pas confondre centralisation et accès libre : une donnée agricole reste sensible et son partage doit être encadré.',
    'Vérifier quels services sont réellement intégrés au moment de l’usage : une plateforme évolutive n’offre pas tout dès le départ.',
    'Distinguer promesse technique et bénéfice mesuré : gain de temps, réduction d’erreurs, qualité du conseil ou simplification administrative doivent pouvoir être observés.',
    'Regarder la dépendance numérique : connexion, matériel, accompagnement et compréhension des consentements conditionnent l’usage réel par les fermes.',
];

$questions = [
    'Quelle donnée est partagée : troupeau, lait, parcelle, météo, conseil, document administratif ou indicateur économique ?',
    'Qui demande l’accès, pour quelle durée et pour quel service précis ?',
    'L’agriculteur peut-il modifier ou retirer un consentement facilement ?',
    'Le service évite-t-il réellement une double saisie ou ajoute-t-il une couche numérique supplémentaire ?',
    'Les sources de données et les limites de l’indicateur affiché sont-elles compréhensibles ?',
];

$examples = [
    'Un tableau de bord peut rassembler des alertes issues de plusieurs outils, puis renvoyer vers le service d’origine pour l’analyse détaillée.',
    'Une application de gestion d’élevage peut exploiter des données déjà connues par un organisme partenaire si l’échange est techniquement compatible et autorisé.',
    'Une donnée météo, parcellaire ou sanitaire devient plus utile lorsqu’elle peut être reliée à une décision concrète : pâturage, intervention, suivi laitier ou conseil.',
];

$relatedSlugs = [
    'agriculture-de-precision',
    'tracabilite',
    'filiere',
    'pac',
    'systeme-alimentaire-territorial',
    'resilience',
];

$relatedTerms = [];
foreach ($relatedSlugs as $relatedSlug) {
    $related = glossaryTermBySlug($glossary, $relatedSlug);
    if (is_array($related) && isset($related['term']) && is_string($related['term'])) {
        $relatedTerms[] = $related;
    }
}

$references = [
    [
        'label' => 'WALLeSmart — site officiel',
        'url' => 'https://www.wallesmart.be/',
    ],
    [
        'label' => 'WALLeSmart — services et fonctionnement',
        'url' => 'https://www.wallesmart.be/nos-services',
    ],
    [
        'label' => 'WALLeSmart — origine, gouvernance et partenaires',
        'url' => 'https://www.wallesmart.be/qui-sommes-nous',
    ],
    [
        'label' => 'CRA-W — projet WalleSmart',
        'url' => 'https://www.cra.wallonie.be/fr/wallesmart',
    ],
    [
        'label' => 'CRA-W — alléger le quotidien numérique des agriculteurs',
        'url' => 'https://www.cra.wallonie.be/fr/wallesmart-alleger-le-quotidien-numerique-des-agriculteurs',
    ],
];
?>

<section aria-labelledby="glossary-term-title" class="shadow-soft glossary-detail">
    <p><a href="?page=glossaire">Retour au glossaire</a></p>
    <p class="eyebrow">Numérique agricole, données et gouvernance</p>
    <h2 id="glossary-term-title"><?= e($term) ?></h2>

    <article class="card resource-summary">
        <p><strong>Définition courte :</strong> <?= e($definition) ?></p>
        <p>WALLeSmart doit être compris comme une infrastructure de coordination numérique : son enjeu n’est pas seulement de “mettre des données en ligne”, mais de rendre des outils agricoles compatibles, utiles et gouvernables par les utilisateurs concernés.</p>
    </article>

    <div class="resource-detail-grid">
        <article class="card">
            <h3>Le problème de départ</h3>
            <ul class="list-tight">
                <?php foreach ($problems as $line): ?>
                    <li><?= e($line) ?></li>
                <?php endforeach; ?>
            </ul>
        </article>

        <article class="card">
            <h3>Comment ça fonctionne</h3>
            <ul class="list-tight">
                <?php foreach ($howItWorks as $line): ?>
                    <li><?= e($line) ?></li>
                <?php endforeach; ?>
            </ul>
        </article>
    </div>

    <article class="card">
        <h3>Contexte wallon</h3>
        <p>La Wallonie dispose déjà d’outils agricoles spécialisés : suivi d’élevage, données laitières, météo, parcelles, santé animale, conseils techniques ou démarches administratives. WALLeSmart vise à réduire la fragmentation de cet écosystème en facilitant les échanges entre services compatibles.</p>
        <p>La fiche ne doit pas présenter la plateforme comme une solution magique. Son intérêt dépend de l’intégration effective des services, de la qualité des données, de la clarté des consentements et de l’accompagnement des utilisateurs.</p>
    </article>

    <div class="resource-detail-grid">
        <section class="card">
            <h3>Usages concrets</h3>
            <ul class="list-tight">
                <?php foreach ($uses as $line): ?>
                    <li><?= e($line) ?></li>
                <?php endforeach; ?>
            </ul>
        </section>

        <section class="card">
            <h3>Exemples lisibles</h3>
            <ul class="list-tight">
                <?php foreach ($examples as $line): ?>
                    <li><?= e($line) ?></li>
                <?php endforeach; ?>
            </ul>
        </section>
    </div>

    <div class="resource-detail-grid">
        <section class="card">
            <h3>Points de vigilance</h3>
            <ul class="list-tight">
                <?php foreach ($watchPoints as $line): ?>
                    <li><?= e($line) ?></li>
                <?php endforeach; ?>
            </ul>
        </section>

        <section class="card">
            <h3>Questions à poser</h3>
            <ul class="list-tight">
                <?php foreach ($questions as $line): ?>
                    <li><?= e($line) ?></li>
                <?php endforeach; ?>
            </ul>
        </section>
    </div>

    <article class="card">
        <h3>À retenir</h3>
        <p>WALLeSmart n’est pas un simple annuaire d’applications. C’est une tentative de rendre le numérique agricole wallon plus interopérable, plus sûr et plus lisible. La bonne question n’est donc pas seulement “que fait la plateforme ?”, mais “quelle donnée circule, avec quel accord, pour produire quelle décision utile sur la ferme ?”.</p>
    </article>

    <?php if ($relatedTerms !== []): ?>
        <article class="card">
            <h3>Termes liés</h3>
            <ul class="related-terms">
                <?php foreach ($relatedTerms as $relatedTerm): ?>
                    <?php
                    $relatedName = isset($relatedTerm['term']) && is_string($relatedTerm['term']) ? $relatedTerm['term'] : '';
                    if ($relatedName === '') {
                        continue;
                    }
                    ?>
                    <li><a href="?page=glossaire&amp;term=<?= e(glossarySlug($relatedName)) ?>"><?= e($relatedName) ?></a></li>
                <?php endforeach; ?>
            </ul>
        </article>
    <?php endif; ?>

    <article class="card references-card">
        <h3>Sources utiles</h3>
        <p class="meta">Sources consultées pour reformuler la fiche sans recopier les textes institutionnels.</p>
        <ul class="reference-list">
            <?php foreach ($references as $reference): ?>
                <li><a href="<?= e($reference['url']) ?>" rel="noopener noreferrer" target="_blank"><?= e($reference['label']) ?></a></li>
            <?php endforeach; ?>
        </ul>
    </article>
</section>
