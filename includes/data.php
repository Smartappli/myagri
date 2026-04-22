<?php

declare(strict_types=1);

$hero = [
    'title' => 'Portail Agriculture Wallonie',
    'subtitle' => 'Comprendre les filières, les enjeux et les initiatives agricoles en Wallonie.',
    'cta' => 'Découvrir les filières',
];

$stats = [
    [
        'label' => 'Exploitations familiales',
        'value' => 'Majoritaires',
        'description' => 'Le tissu agricole wallon repose largement sur des structures familiales ancrées dans les territoires ruraux.',
    ],
    [
        'label' => 'Diversité des productions',
        'value' => 'Très élevée',
        'description' => 'Grandes cultures, élevage, horticulture, maraîchage, arboriculture et circuits courts coexistent sur le territoire.',
    ],
    [
        'label' => 'Transition agroécologique',
        'value' => 'En cours',
        'description' => 'Les agriculteurs adaptent progressivement leurs pratiques face aux enjeux climatiques, économiques et sociétaux.',
    ],
];

$sectors = [
    [
        'name' => 'Grandes cultures',
        'icon' => '🌾',
        'focus' => 'Céréales, pommes de terre, betteraves et protéagineux structurent une part importante des surfaces cultivées.',
        'public_info' => [
            'Rôle clé dans l’alimentation humaine et animale.',
            'Sensibilité aux aléas climatiques et aux prix mondiaux.',
            'Évolutions vers des rotations plus diversifiées.',
        ],
    ],
    [
        'name' => 'Élevage bovin',
        'icon' => '🐄',
        'focus' => 'La Wallonie se distingue par ses élevages laitiers et viandeux, souvent liés aux prairies permanentes.',
        'public_info' => [
            'Contribue à l’entretien des paysages ruraux.',
            'Enjeux de bien-être animal et de rentabilité.',
            'Valorisation locale via des labels de qualité.',
        ],
    ],
    [
        'name' => 'Maraîchage & horticulture',
        'icon' => '🥕',
        'focus' => 'Ces filières rapprochent producteurs et citoyens via marchés, paniers et vente à la ferme.',
        'public_info' => [
            'Production de légumes et plantes en proximité.',
            'Demande croissante pour des produits saisonniers.',
            'Forte création de valeur en circuit court.',
        ],
    ],
    [
        'name' => 'Arboriculture',
        'icon' => '🍎',
        'focus' => 'Pommes, poires et petits fruits participent à l’identité agricole de plusieurs bassins wallons.',
        'public_info' => [
            'Soumise aux risques de gel printanier.',
            'Développement de variétés résistantes.',
            'Importance de la transformation locale (jus, compotes).',
        ],
    ],
];

$initiatives = [
    [
        'title' => 'Agroécologie et sols vivants',
        'description' => 'Promotion des couverts végétaux, réduction du travail du sol et augmentation de la matière organique pour préserver la fertilité.',
        'impact' => 'Amélioration de la résilience des parcelles face à la sécheresse et à l’érosion.',
    ],
    [
        'title' => 'Circuits courts et alimentation locale',
        'description' => 'Développement des points de vente directe, coopératives citoyennes et approvisionnement local des cantines.',
        'impact' => 'Renforcement du lien ville-campagne et meilleure rémunération du producteur.',
    ],
    [
        'title' => 'Agriculture biologique',
        'description' => 'Progression des exploitations certifiées et accompagnement technique pour la conversion.',
        'impact' => 'Réduction de certains intrants de synthèse et valorisation commerciale différenciée.',
    ],
    [
        'title' => 'Numérique et agriculture de précision',
        'description' => 'Usage de capteurs, outils d’aide à la décision et cartographie pour optimiser l’usage des ressources.',
        'impact' => 'Pilotage plus fin des apports et gains potentiels d’efficience.',
    ],
];

$faq = [
    [
        'q' => 'Pourquoi l’agriculture wallonne est-elle importante pour le grand public ?',
        'a' => 'Elle nourrit la population, entretient les paysages, soutient l’économie locale et joue un rôle clé dans la transition écologique.',
    ],
    [
        'q' => 'Qu’est-ce qu’un circuit court ?',
        'a' => 'Un mode de commercialisation avec peu ou pas d’intermédiaires entre producteur et consommateur.',
    ],
    [
        'q' => 'Comment soutenir les agriculteurs locaux ?',
        'a' => 'Acheter des produits de saison, privilégier les labels régionaux, visiter les fermes pédagogiques et participer aux initiatives citoyennes.',
    ],
    [
        'q' => 'L’agriculture peut-elle contribuer à la lutte contre le changement climatique ?',
        'a' => 'Oui, via des pratiques de stockage du carbone dans les sols, la diversification des rotations et une gestion optimisée des intrants.',
    ],
];

$resources = [
    ['name' => 'Formations et métiers', 'description' => 'Découvrir les parcours de formation agricole et agroalimentaire en Wallonie.'],
    ['name' => 'Fermes pédagogiques', 'description' => 'Comprendre l’agriculture sur le terrain grâce aux visites et ateliers pour familles et écoles.'],
    ['name' => 'Alimentation durable', 'description' => 'Conseils pratiques pour consommer local, saisonnier et responsable.'],
    ['name' => 'Innovation et recherche', 'description' => 'Suivre les projets pilotes sur l’eau, le sol, les semences et l’énergie en agriculture.'],
];
