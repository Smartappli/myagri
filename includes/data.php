<?php

declare(strict_types=1);

$site = [
    'title' => 'AgriWallonie — Portail citoyen',
    'subtitle' => 'Toute l’agriculture wallonne expliquée simplement : productions, alimentation, environnement, économie et métiers.',
    'updated_at' => '22 avril 2026',
];

$quickFacts = [
    [
        'title' => 'À quoi sert l’agriculture ?',
        'content' => 'Elle produit notre alimentation, entretient les paysages, alimente des filières locales et participe à la vitalité des communes rurales.',
    ],
    [
        'title' => 'Pourquoi en parler maintenant ?',
        'content' => 'Climat, biodiversité, prix alimentaires et souveraineté alimentaire transforment les attentes envers le secteur agricole.',
    ],
    [
        'title' => 'Quel est l’objectif du portail ?',
        'content' => 'Donner des repères fiables et pédagogiques au grand public sans jargon inutile.',
    ],
];

$pillars = [
    ['name' => 'Produire', 'description' => 'Assurer une alimentation de qualité avec des filières diversifiées et résilientes.'],
    ['name' => 'Préserver', 'description' => 'Protéger l’eau, les sols, la biodiversité et réduire les émissions de gaz à effet de serre.'],
    ['name' => 'Partager', 'description' => 'Renforcer le lien producteurs-consommateurs via la pédagogie et les circuits courts.'],
    ['name' => 'Innover', 'description' => 'Mobiliser recherche, numérique et coopération territoriale.'],
];

$sectors = [
    [
        'slug' => 'cultures',
        'label' => 'Grandes cultures',
        'emoji' => '🌾',
        'summary' => 'Céréales, pommes de terre, betteraves et cultures protéiques structurent fortement l’espace agricole wallon.',
        'enjeux' => [
            'Rentabilité dépendante des prix et du climat.',
            'Réduction de la dépendance aux intrants.',
            'Diversification des rotations pour améliorer les sols.',
        ],
        'bon_a_savoir' => 'La pomme de terre est un maillon majeur des filières agroalimentaires régionales.',
    ],
    [
        'slug' => 'elevage',
        'label' => 'Élevage bovin et laitier',
        'emoji' => '🐄',
        'summary' => 'L’élevage valorise les prairies et participe à l’identité agricole wallonne, notamment en zones herbagères.',
        'enjeux' => [
            'Prix rémunérateur pour les producteurs.',
            'Bien-être animal et conditions de travail.',
            'Réduction de l’empreinte carbone par l’alimentation et la gestion des effluents.',
        ],
        'bon_a_savoir' => 'Les prairies permanentes jouent un rôle important dans le stockage du carbone.',
    ],
    [
        'slug' => 'maraichage',
        'label' => 'Maraîchage, horticulture et vergers',
        'emoji' => '🥕',
        'summary' => 'Ces filières de proximité répondent à la demande croissante en produits frais, saisonniers et locaux.',
        'enjeux' => [
            'Main-d’œuvre qualifiée et saisonnalité.',
            'Gestion de l’eau et adaptation aux fortes chaleurs.',
            'Organisation logistique des circuits courts.',
        ],
        'bon_a_savoir' => 'La vente directe permet souvent de mieux valoriser le travail agricole.',
    ],
];

$focusThemes = [
    [
        'title' => 'Eau et sécheresse',
        'details' => 'Stockage d’eau, couverture des sols et adaptation des itinéraires techniques deviennent prioritaires dans de nombreuses exploitations.',
    ],
    [
        'title' => 'Sols vivants',
        'details' => 'Allongement des rotations, couverts végétaux et limitation du tassement sont au cœur de la fertilité durable.',
    ],
    [
        'title' => 'Biodiversité utile',
        'details' => 'Haies, bandes fleuries et infrastructures agroécologiques favorisent pollinisateurs et régulation naturelle des ravageurs.',
    ],
    [
        'title' => 'Énergie et climat',
        'details' => 'Efficacité énergétique, valorisation de coproduits et sobriété des intrants renforcent la résilience des fermes.',
    ],
];

$citizenActions = [
    'Privilégier les produits locaux et de saison.',
    'Visiter une ferme pédagogique pour comprendre les réalités du terrain.',
    'Comparer les labels et poser des questions sur l’origine des produits.',
    'Soutenir les initiatives collectives : coopératives, magasins de producteurs, paniers hebdomadaires.',
];

$faq = [
    [
        'q' => 'L’agriculture wallonne est-elle seulement intensive ?',
        'a' => 'Non. On y trouve une grande diversité de modèles : conventionnel, biologique, circuits courts, systèmes herbagers, etc.',
    ],
    [
        'q' => 'Pourquoi les prix varient-ils autant ?',
        'a' => 'Ils dépendent des coûts de production, des marchés internationaux, de la météo et de la chaîne de transformation/distribution.',
    ],
    [
        'q' => 'Le bio suffit-il à résoudre tous les enjeux ?',
        'a' => 'Le bio apporte des réponses importantes, mais la transition mobilise aussi d’autres leviers : sols, eau, énergie, rémunération et coopération.',
    ],
    [
        'q' => 'Comment parler d’agriculture avec les enfants ?',
        'a' => 'Par des exemples concrets : saisonnalité des fruits, visite de ferme, potager scolaire, lecture d’étiquettes.',
    ],
];

$glossary = [
    ['term' => 'Circuit court', 'definition' => 'Mode de vente avec peu ou pas d’intermédiaires entre producteur et consommateur.'],
    ['term' => 'Agroécologie', 'definition' => 'Approche qui applique les principes de l’écologie aux systèmes agricoles.'],
    ['term' => 'Prairie permanente', 'definition' => 'Surface herbagère installée depuis plusieurs années, essentielle pour l’élevage et les écosystèmes.'],
    ['term' => 'Rotation', 'definition' => 'Succession planifiée des cultures sur une même parcelle pour préserver la fertilité et limiter les risques.'],
];
