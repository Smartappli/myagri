<?php
if (!is_array($selectedGlossaryTerm)) {
    return;
}

$term = isset($selectedGlossaryTerm['term']) && is_string($selectedGlossaryTerm['term']) ? $selectedGlossaryTerm['term'] : 'Terme';
$definition = isset($selectedGlossaryTerm['definition']) && is_string($selectedGlossaryTerm['definition']) ? $selectedGlossaryTerm['definition'] : '';
$termSlug = glossarySlug($term);

$profiles = [
    'sols' => [
        'theme' => 'Sols, fertilité et protection des parcelles',
        'context' => 'En Wallonie, la qualité des sols conditionne les rendements, la résistance aux périodes sèches, la limitation de l’érosion et la capacité des fermes à réduire certains achats d’intrants.',
        'producer_use' => 'Pour une exploitation, cette notion sert à planifier les rotations, les couverts, les apports organiques, le travail du sol et les périodes d’intervention sans dégrader la structure des parcelles.',
        'citizen_use' => 'Pour un citoyen ou un enseignant, elle aide à comprendre pourquoi un champ ne se résume pas à une surface de production : c’est aussi un milieu vivant, fragile et long à restaurer.',
        'indicators' => ['Présence de couverts ou de résidus végétaux entre deux cultures.', 'Stabilité de la structure du sol après pluie intense.', 'Teneur en matière organique, activité biologique et signes d’érosion visibles.'],
        'pitfalls' => ['Réduire le sujet à une technique isolée au lieu de regarder l’ensemble du système de culture.', 'Confondre fertilité immédiate et fertilité durable.', 'Oublier que le relief, le type de sol et la météo modifient fortement les résultats.'],
        'example' => 'Une ferme de grandes cultures peut combiner rotations plus longues, couverts végétaux et apports organiques pour protéger les parcelles en hiver et améliorer la portance au printemps.',
        'related' => ['fertilite-du-sol', 'matiere-organique', 'humus', 'erosion-des-sols', 'couvert-vegetal', 'cultures-intermediaires', 'reserve-utile-du-sol', 'semis-direct'],
    ],
    'elevage' => [
        'theme' => 'Élevage, prairies et autonomie des fermes',
        'context' => 'Les systèmes herbagers wallons reposent souvent sur un équilibre entre prairies, fourrages, troupeaux, bâtiments, disponibilité de main-d’œuvre et valorisation économique du lait ou de la viande.',
        'producer_use' => 'Pour un éleveur, cette notion aide à ajuster la conduite du troupeau, la gestion des prairies, les stocks fourragers, les coûts alimentaires et le bien-être animal.',
        'citizen_use' => 'Pour le public, elle permet de mieux comprendre le rôle des prairies, la saisonnalité du pâturage et les différences entre modèles d’élevage.',
        'indicators' => ['Part de l’alimentation produite sur la ferme.', 'État des prairies, disponibilité de l’herbe et pression de pâturage.', 'Coûts alimentaires, santé du troupeau et régularité de production.'],
        'pitfalls' => ['Comparer des élevages sans tenir compte des surfaces disponibles.', 'Oublier que météo, altitude et qualité des prairies modifient les choix techniques.', 'Résumer l’élevage à un seul indicateur environnemental ou économique.'],
        'example' => 'Un élevage laitier peut sécuriser son autonomie en alternant pâturage tournant, fauche, stockage de fourrages et ajustement du nombre d’animaux à la surface disponible.',
        'related' => ['prairie-permanente', 'prairie-temporaire', 'autonomie-fourragere', 'autonomie-proteique', 'paturage-tournant', 'densite-de-chargement', 'effluents-d-elevage', 'polyculture-elevage'],
    ],
    'filiere' => [
        'theme' => 'Filières, valeur et choix de consommation',
        'context' => 'Une production agricole prend de la valeur à travers la transformation, la logistique, la distribution, la qualité, l’origine et la relation de confiance avec les acheteurs.',
        'producer_use' => 'Pour une ferme ou une coopérative, cette notion sert à choisir ses débouchés, négocier un prix, organiser la transformation et rendre l’offre lisible.',
        'citizen_use' => 'Pour un consommateur, elle aide à comparer origine, labels, prix au kilo, saisonnalité, niveau de transformation et rémunération des producteurs.',
        'indicators' => ['Nombre d’intermédiaires et transparence du prix.', 'Lieu de production et lieu de transformation.', 'Existence d’un cahier des charges, d’un label ou d’une relation directe avec le producteur.'],
        'pitfalls' => ['Confondre produit local, produit transformé localement et produit vendu localement.', 'Penser qu’un logo suffit à résumer la qualité globale.', 'Oublier les coûts de main-d’œuvre, de stockage, de transport et de transformation.'],
        'example' => 'Un fruit cultivé en Wallonie peut être vendu brut au marché, transformé en jus à la ferme ou intégré dans une filière plus longue avec conditionnement et distribution.',
        'related' => ['filiere', 'circuit-court', 'vente-directe', 'valeur-ajoutee', 'tracabilite', 'cahier-des-charges', 'certification', 'prix-au-kilo'],
    ],
    'transition' => [
        'theme' => 'Transition agroécologique et résilience',
        'context' => 'La transition agricole ne consiste pas à appliquer une recette unique : elle combine diagnostic local, essais progressifs, accompagnement technique, viabilité économique et adaptation au climat.',
        'producer_use' => 'Pour une ferme, cette notion sert à prioriser des changements réalistes, mesurer leurs effets et éviter de déplacer un problème environnemental vers un problème économique ou social.',
        'citizen_use' => 'Pour le public, elle donne des repères pour comprendre les arbitrages entre production alimentaire, biodiversité, revenu agricole, énergie, eau et attentes sociétales.',
        'indicators' => ['Réduction de dépendance à une ressource fragile.', 'Maintien du revenu et de la qualité de vie au travail.', 'Effets mesurables sur sols, eau, biodiversité ou émissions.'],
        'pitfalls' => ['Présenter la transition comme immédiate ou identique partout.', 'Opposer systématiquement production et environnement.', 'Négliger le temps d’apprentissage, les investissements et les risques économiques.'],
        'example' => 'Une exploitation peut tester des couverts, allonger ses rotations, développer une vente directe limitée et suivre les coûts avant de généraliser les changements.',
        'related' => ['agroecologie', 'transition-agroecologique', 'agriculture-regeneratrice', 'agriculture-biologique', 'agriculture-integree', 'agriculture-de-precision', 'services-ecosystemiques', 'diversification'],
    ],
    'climat' => [
        'theme' => 'Climat, eau, carbone et énergie',
        'context' => 'Les épisodes de sécheresse, les pluies intenses, les coûts énergétiques et les objectifs climatiques influencent directement les décisions agricoles en Wallonie.',
        'producer_use' => 'Pour une exploitation, cette notion aide à gérer les risques, sécuriser les ressources, mesurer les émissions ou stockages et choisir des investissements proportionnés.',
        'citizen_use' => 'Pour le public, elle rend visibles les liens entre pratiques agricoles, alimentation, paysage, énergie, eau et adaptation climatique.',
        'indicators' => ['Disponibilité en eau et sensibilité des cultures au stress.', 'Émissions évitées ou carbone stocké selon les pratiques.', 'Consommation énergétique, autonomie et valorisation de coproduits.'],
        'pitfalls' => ['Isoler un indicateur climatique sans regarder les autres impacts.', 'Confondre stockage temporaire et réduction durable des émissions.', 'Sous-estimer l’effet des années météo extrêmes sur les résultats.'],
        'example' => 'Une ferme peut associer haies, couverts, irrigation raisonnée et efficacité énergétique pour réduire sa vulnérabilité aux sécheresses et aux hausses de coûts.',
        'related' => ['bilan-carbone', 'sequestration-carbone', 'stress-hydrique', 'irrigation-raisonnee', 'empreinte-eau', 'gestion-de-l-eau-a-la-parcelle', 'methanisation', 'digestat'],
    ],
    'territoire' => [
        'theme' => 'Territoire, politiques publiques et usages du foncier',
        'context' => 'L’agriculture dépend de décisions collectives : accès au foncier, règles d’urbanisation, aides publiques, données partagées, infrastructures et choix alimentaires du territoire.',
        'producer_use' => 'Pour une ferme ou un porteur de projet, cette notion aide à anticiper les règles, les contraintes administratives, les partenariats locaux et les possibilités d’accompagnement.',
        'citizen_use' => 'Pour une collectivité ou un citoyen, elle permet de comprendre comment les décisions d’aménagement, de restauration collective ou d’achat public influencent les filières agricoles.',
        'indicators' => ['Clarté des règles applicables et des guichets compétents.', 'Surface agricole préservée et accessibilité pour les projets.', 'Qualité des données, des partenariats et du suivi territorial.'],
        'pitfalls' => ['Confondre objectif politique et obligation déjà opérationnelle.', 'Oublier que les règles évoluent selon niveaux européen, régional et communal.', 'Réduire le territoire à une carte sans examiner les acteurs qui y travaillent.'],
        'example' => 'Une commune peut protéger des terres agricoles, soutenir un marché local et orienter les cantines vers des achats plus saisonniers en coordination avec les producteurs.',
        'related' => ['pac', 'conditionnalite', 'eco-regime', 'maec', 'natura-2000', 'zero-artificialisation-nette-zan', 'souverainete-alimentaire', 'systeme-alimentaire-territorial'],
    ],
];

$profileBySlug = [
    'rotation' => 'sols',
    'assolement' => 'sols',
    'amendement-organique' => 'sols',
    'analyse-de-sol' => 'sols',
    'battance' => 'sols',
    'couvert-vegetal' => 'sols',
    'couverts-permanents' => 'sols',
    'cultures-associees' => 'sols',
    'culture-derobee' => 'sols',
    'erosion-des-sols' => 'sols',
    'fertilite-du-sol' => 'sols',
    'gestion-integree-des-ravageurs' => 'sols',
    'humus' => 'sols',
    'interculture' => 'sols',
    'intrants' => 'sols',
    'labour' => 'sols',
    'matiere-organique' => 'sols',
    'mycorhizes' => 'sols',
    'ph-du-sol' => 'sols',
    'plan-de-fumure' => 'sols',
    'proteagineux' => 'sols',
    'ruissellement' => 'sols',
    'auxiliaires-de-culture' => 'sols',
    'bande-enherbee' => 'sols',
    'biodiversite-fonctionnelle' => 'sols',
    'compost' => 'sols',
    'cultures-intermediaires' => 'sols',
    'drainage-agricole' => 'sols',
    'effluents-d-elevage' => 'sols',
    'nitrates' => 'sols',
    'reserve-utile-du-sol' => 'sols',
    'semis-direct' => 'sols',
    'tassement-du-sol' => 'sols',
    'techniques-culturales-simplifiees' => 'sols',
    'travail-du-sol' => 'sols',
    'zone-tampon' => 'sols',
    'prairie-permanente' => 'elevage',
    'autonomie-fourragere' => 'elevage',
    'polyculture-elevage' => 'elevage',
    'densite-de-chargement' => 'elevage',
    'elevage-extensif' => 'elevage',
    'bien-etre-animal' => 'elevage',
    'culture-fourragere' => 'elevage',
    'ensilage' => 'elevage',
    'fauche' => 'elevage',
    'fourrage' => 'elevage',
    'paturage-tournant' => 'elevage',
    'sante-animale' => 'elevage',
    'unite-gros-betail-ugb' => 'elevage',
    'autonomie-proteique' => 'elevage',
    'prairie-temporaire' => 'elevage',
    'circuit-court' => 'filiere',
    'filiere' => 'filiere',
    'valeur-ajoutee' => 'filiere',
    'tracabilite' => 'filiere',
    'aop-igp' => 'filiere',
    'prix-remunerateur' => 'filiere',
    'saisonnalite' => 'filiere',
    'transformation-a-la-ferme' => 'filiere',
    'pertes-post-recolte' => 'filiere',
    'cahier-des-charges' => 'filiere',
    'certification' => 'filiere',
    'chaine-du-froid' => 'filiere',
    'conservation-des-aliments' => 'filiere',
    'cooperative-agricole' => 'filiere',
    'groupe-d-achat' => 'filiere',
    'logistique-alimentaire' => 'filiere',
    'point-relais' => 'filiere',
    'prix-au-kilo' => 'filiere',
    'prix-de-revient' => 'filiere',
    'qualite-differenciee' => 'filiere',
    'relocalisation-alimentaire' => 'filiere',
    'restauration-collective' => 'filiere',
    'stockage-a-la-ferme' => 'filiere',
    'systeme-alimentaire-territorial' => 'filiere',
    'vente-directe' => 'filiere',
    'agroecologie' => 'transition',
    'transition-agroecologique' => 'transition',
    'resilience' => 'transition',
    'agriculture-biologique' => 'transition',
    'agriculture-de-precision' => 'transition',
    'agroforesterie' => 'transition',
    'bocage' => 'transition',
    'diversification' => 'transition',
    'economie-circulaire' => 'transition',
    'agriculture-regeneratrice' => 'transition',
    'agriculture-integree' => 'transition',
    'agriculture-urbaine' => 'transition',
    'apiculture' => 'transition',
    'capteur-agricole' => 'transition',
    'charge-de-travail' => 'transition',
    'ferme-pedagogique' => 'transition',
    'lutte-biologique' => 'transition',
    'outil-d-aide-a-la-decision' => 'transition',
    'paiement-pour-services-environnementaux' => 'transition',
    'pollinisation' => 'transition',
    'services-ecosystemiques' => 'transition',
    'tableau-de-bord-agricole' => 'transition',
    'variete-resistante' => 'transition',
    'verger-haute-tige' => 'transition',
    'bilan-carbone' => 'climat',
    'biomasse' => 'climat',
    'decarbonation-agricole' => 'climat',
    'energie-renouvelable-agricole' => 'climat',
    'haie-vive' => 'climat',
    'irrigation-raisonnee' => 'climat',
    'methanisation' => 'climat',
    'sequestration-carbone' => 'climat',
    'stress-hydrique' => 'climat',
    'digestat' => 'climat',
    'empreinte-eau' => 'climat',
    'bassin-versant' => 'climat',
    'gestion-de-l-eau-a-la-parcelle' => 'climat',
    'zone-humide' => 'climat',
    'pac' => 'territoire',
    'souverainete-alimentaire' => 'territoire',
    'wallesmart' => 'territoire',
    'zero-artificialisation-nette-zan' => 'territoire',
    'consentement-des-donnees' => 'territoire',
    'conditionnalite' => 'territoire',
    'eco-regime' => 'territoire',
    'exploitation-familiale' => 'territoire',
    'foncier-agricole' => 'territoire',
    'interoperabilite' => 'territoire',
    'maec' => 'territoire',
    'marche-public-alimentaire' => 'territoire',
    'natura-2000' => 'territoire',
    'projet-alimentaire-territorial' => 'territoire',
];

$profileKey = $profileBySlug[$termSlug] ?? 'transition';
$profile = $profiles[$profileKey];

$introduction = $glossaryIntroduction ?? (
    $definition !== ''
        ? $term . ' est une notion clé pour comprendre l’agriculture wallonne. ' . $definition . ' La fiche ci-dessous explique son utilité, ses effets concrets et les points à vérifier avant de l’utiliser dans un cours, une discussion citoyenne ou un projet agricole.'
        : 'Cette notion sert à décrire un aspect précis des pratiques, des chaînes de valeur ou de la gestion quotidienne de l’agriculture.'
);

$whatToSee = $glossaryWhatToSee ?? $profile['indicators'];
$whyImportant = $glossaryWhyImportant ?? [
    'Mieux comprendre les décisions techniques prises sur une ferme ou dans une filière.',
    'Relier un mot agricole à des effets observables sur le revenu, les sols, l’eau, la biodiversité ou l’organisation locale.',
    'Éviter les raccourcis dans les débats publics en regardant les contraintes de terrain et les preuves disponibles.',
];
$actions = $glossaryActions ?? [
    'Identifier où le terme apparaît : document technique, étiquette, projet communal, visite de ferme ou débat public.',
    'Demander quel indicateur permet de vérifier concrètement l’information.',
    'Comparer plusieurs situations locales avant de généraliser une conclusion.',
];

$relatedTerms = [];
if (isset($profile['related']) && is_array($profile['related'])) {
    foreach ($profile['related'] as $relatedSlug) {
        if (!is_string($relatedSlug) || $relatedSlug === $termSlug) {
            continue;
        }

        $related = glossaryTermBySlug($glossary, $relatedSlug);
        if (is_array($related) && isset($related['term']) && is_string($related['term'])) {
            $relatedTerms[] = $related;
        }
    }
}

$verificationQuestions = [
    'Quel problème concret ce terme permet-il de comprendre ou de résoudre ?',
    'Quels acteurs sont concernés : producteur, transformateur, collectivité, consommateur, enseignant ?',
    'Quels indicateurs permettent de vérifier que l’effet annoncé est réel ?',
    'Quelles limites faut-il mentionner pour éviter une explication trop simpliste ?',
];
?>

<section aria-labelledby="glossary-term-title" class="shadow-soft glossary-detail">
    <p><a href="?page=glossaire">Retour au glossaire</a></p>
    <p class="eyebrow"><?= e($profile['theme']) ?></p>
    <h2 id="glossary-term-title"><?= e($term) ?></h2>

    <article class="card resource-summary">
        <p><?= e($introduction) ?></p>
    </article>

    <div class="resource-detail-grid">
        <article class="card">
            <h3>Définition développée</h3>
            <p><?= e($definition) ?></p>
            <p>Dans la pratique, ce terme doit toujours être replacé dans un contexte précis : type de ferme, sol, climat local, débouchés économiques, règles applicables et objectifs poursuivis. C’est ce contexte qui permet de passer d’une définition courte à une compréhension réellement utile.</p>
        </article>

        <article class="card">
            <h3>À quoi ça sert ?</h3>
            <ul class="list-tight">
                <?php foreach ($whyImportant as $line): ?>
                    <li><?= e($line) ?></li>
                <?php endforeach; ?>
            </ul>
        </article>
    </div>

    <article class="card">
        <h3>Contexte en Wallonie</h3>
        <p><?= e($profile['context']) ?></p>
        <p>Cette lecture territoriale est importante, car une même notion peut produire des effets différents selon les provinces, les sols, les filières présentes, les infrastructures de transformation et les possibilités de vente locale.</p>
    </article>

    <div class="resource-detail-grid">
        <section class="card">
            <h3>Ce qu’il faut observer</h3>
            <ul class="list-tight">
                <?php foreach ($whatToSee as $line): ?>
                    <li><?= e($line) ?></li>
                <?php endforeach; ?>
            </ul>
        </section>

        <section class="card">
            <h3>Usage côté ferme</h3>
            <p><?= e($profile['producer_use']) ?></p>
        </section>

        <section class="card">
            <h3>Usage côté citoyen</h3>
            <p><?= e($profile['citizen_use']) ?></p>
        </section>
    </div>

    <div class="resource-detail-grid">
        <section class="card">
            <h3>Exemple concret</h3>
            <p><?= e($profile['example']) ?></p>
        </section>

        <section class="card">
            <h3>Points de vigilance</h3>
            <ul class="list-tight">
                <?php foreach ($profile['pitfalls'] as $line): ?>
                    <li><?= e($line) ?></li>
                <?php endforeach; ?>
            </ul>
        </section>

        <section class="card">
            <h3>À appliquer</h3>
            <ul class="list-tight">
                <?php foreach ($actions as $line): ?>
                    <li><?= e($line) ?></li>
                <?php endforeach; ?>
            </ul>
        </section>
    </div>

    <article class="card">
        <h3>Questions à se poser</h3>
        <ul class="list-tight">
            <?php foreach ($verificationQuestions as $question): ?>
                <li><?= e($question) ?></li>
            <?php endforeach; ?>
        </ul>
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
</section>
