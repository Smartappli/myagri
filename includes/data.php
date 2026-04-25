<?php

declare(strict_types=1);

/**
 * @return array<string, mixed>
 */
function getPortalData(): array
{
    return [
        'site' => [
            'title' => 'MyAgri — Portail citoyen',
            'subtitle' => 'Comprendre l’agriculture wallonne : alimentation, territoires, environnement, économie et métiers.',
            'updated_at' => '25 avril 2026',
        ],
        'quickFacts' => [
            [
                'title' => 'Un enjeu quotidien',
                'content' => 'L’agriculture influence directement le prix, la qualité et la diversité de notre alimentation.',
            ],
            [
                'title' => 'Un rôle territorial',
                'content' => 'Elle structure les paysages, soutient l’emploi local et maintient la vie économique rurale.',
            ],
            [
                'title' => 'Un secteur en transition',
                'content' => 'Les fermes s’adaptent au climat, à la pression économique et aux attentes sociétales.',
            ],
            [
                'title' => 'Un moteur d’innovation',
                'content' => 'Du numérique aux nouvelles variétés, les pratiques évoluent pour produire mieux avec moins de ressources.',
            ],
            [
                'title' => 'Un lien social',
                'content' => 'Marchés, coopératives, fermes pédagogiques et circuits courts rapprochent citoyens et producteurs.',
            ],
        ],
        'pillars' => [
            ['name' => 'Produire', 'description' => 'Assurer une production fiable, diversifiée et de qualité pour répondre aux besoins alimentaires.'],
            ['name' => 'Préserver', 'description' => 'Protéger l’eau, les sols, le climat et la biodiversité pour maintenir la capacité de production sur le long terme.'],
            ['name' => 'Relier', 'description' => 'Créer du lien entre producteurs, transformateurs, distributeurs et citoyens via des filières lisibles.'],
            ['name' => 'Innover', 'description' => 'S’appuyer sur la recherche, l’expérimentation et les retours terrain pour améliorer les pratiques.'],
        ],
        'sectors' => [
            [
                'label' => 'Grandes cultures',
                'emoji' => '🌾',
                'summary' => 'Céréales, pommes de terre et betteraves occupent une place importante.',
                'enjeux' => [
                    'Gestion des risques climatiques.',
                    'Fertilité des sols et rotations.',
                    'Stabilité économique des exploitations.',
                    'Disponibilité de l’eau et maîtrise des intrants.',
                ],
                'public_actions' => [
                    'Privilégier la saisonnalité et l’origine locale.',
                    'S’informer sur les filières de transformation régionales.',
                    'Réduire le gaspillage alimentaire pour valoriser au mieux le travail agricole.',
                ],
            ],
            [
                'label' => 'Élevage bovin et laitier',
                'emoji' => '🐄',
                'summary' => 'L’élevage valorise les prairies et alimente les filières laitières et viandeuses.',
                'enjeux' => [
                    'Bien-être animal et revenu des éleveurs.',
                    'Autonomie fourragère et coûts de production.',
                    'Réduction de l’empreinte environnementale.',
                    'Transmission des fermes et renouvellement des générations.',
                ],
                'public_actions' => [
                    'Découvrir les labels et démarches qualité.',
                    'Soutenir les points de vente fermiers.',
                    'Comparer l’origine des produits laitiers et carnés pour encourager les filières locales.',
                ],
            ],
            [
                'label' => 'Maraîchage, horticulture et vergers',
                'emoji' => '🥕',
                'summary' => 'Des productions de proximité adaptées aux circuits courts.',
                'enjeux' => [
                    'Main-d’œuvre, stockage et logistique.',
                    'Irrigation et adaptation aux canicules.',
                    'Valorisation commerciale en vente directe.',
                    'Accès au foncier de proximité pour de nouveaux maraîchers.',
                ],
                'public_actions' => [
                    'Acheter en direct chez les producteurs.',
                    'Diversifier son panier avec des produits de saison.',
                    'Planifier ses menus hebdomadaires pour soutenir une consommation locale régulière.',
                ],
            ],
            [
                'label' => 'Diversification (petits fruits, houblon, viticulture)',
                'emoji' => '🍇',
                'summary' => 'Des filières émergentes créent de la valeur locale et renforcent la résilience des fermes.',
                'enjeux' => [
                    'Investissements de départ et accompagnement technique.',
                    'Structuration des débouchés locaux et touristiques.',
                    'Gestion des risques sanitaires et climatiques.',
                    'Développement de compétences en transformation et commercialisation.',
                ],
                'public_actions' => [
                    'Découvrir les produits locaux transformés (jus, bière, vin, confitures).',
                    'Visiter les exploitations qui ouvrent leurs ateliers au public.',
                    'Choisir des cadeaux alimentaires issus de producteurs régionaux.',
                ],
            ],
        ],
        'focusThemes' => [
            ['title' => 'Eau', 'details' => 'Économiser et mieux stocker l’eau pour sécuriser les productions.'],
            ['title' => 'Sols', 'details' => 'Renforcer la matière organique et limiter l’érosion.'],
            ['title' => 'Biodiversité', 'details' => 'Déployer haies, bandes fleuries et infrastructures écologiques.'],
            ['title' => 'Climat', 'details' => 'Adapter les pratiques et limiter les émissions.'],
            ['title' => 'Énergie', 'details' => 'Réduire les coûts via l’efficacité énergétique et l’autoproduction.'],
            ['title' => 'Numérique', 'details' => 'Mieux piloter les cultures et troupeaux grâce aux données de terrain.'],
        ],

        'provinces' => [
            ['name' => 'Brabant wallon', 'profile' => 'Mosaïque de cultures, maraîchage et transformation locale, avec une forte proximité des bassins de consommation.'],
            ['name' => 'Hainaut', 'profile' => 'Poids important des grandes cultures et de l’agroalimentaire, soutenu par des infrastructures logistiques structurantes.'],
            ['name' => 'Liège', 'profile' => 'Élevage, vergers et filières de valorisation de proximité, avec des initiatives dynamiques en circuits courts.'],
            ['name' => 'Luxembourg', 'profile' => 'Systèmes herbagers, forêts et élevage extensif, dans des paysages où l’équilibre entre production et nature est central.'],
            ['name' => 'Namur', 'profile' => 'Diversité de productions entre grandes cultures, élevage et maraîchage, avec un tissu d’exploitations familiales varié.'],
        ],
        'seasonalCalendar' => [
            ['season' => 'Printemps', 'focus' => 'Semis, gestion de l’eau, protection contre le gel tardif et organisation des premières récoltes.'],
            ['season' => 'Été', 'focus' => 'Récoltes précoces, irrigation ciblée, prévention du stress hydrique et gestion des pics de travail.'],
            ['season' => 'Automne', 'focus' => 'Récoltes principales, semis d’automne, couverts végétaux et préparation des sols pour l’hiver.'],
            ['season' => 'Hiver', 'focus' => 'Entretien du matériel, planification, soins aux animaux et préparation de la campagne suivante.'],
        ],
        'faq' => [
            [
                'q' => 'Pourquoi les prix agricoles sont-ils parfois instables ?',
                'a' => 'Ils dépendent à la fois des marchés mondiaux, de la météo, des coûts de l’énergie et de la transformation.',
            ],
            [
                'q' => 'Le circuit court est-il toujours possible ?',
                'a' => 'Pas pour tous les produits, mais il peut renforcer le lien local et la valeur ajoutée quand il est bien organisé.',
            ],
            [
                'q' => 'Comment sensibiliser les enfants ?',
                'a' => 'Via des visites de fermes, des ateliers alimentaires, des potagers et l’observation des saisons.',
            ],
            [
                'q' => 'Pourquoi parle-t-on autant de souveraineté alimentaire ?',
                'a' => 'Elle vise à garantir une capacité locale à produire une part significative de l’alimentation en cas de crise.',
            ],
            [
                'q' => 'Que signifie “prix juste” pour un agriculteur ?',
                'a' => 'Un prix qui couvre les coûts de production, rémunère le travail et permet d’investir dans la transition.',
            ],
            [
                'q' => 'Comment un citoyen peut-il agir sans augmenter fortement son budget ?',
                'a' => 'En privilégiant la saison, en cuisinant des produits bruts, en limitant le gaspillage et en comparant les points de vente locaux.',
            ],
            [
                'q' => 'Pourquoi les pratiques agricoles varient-elles d’une région à l’autre ?',
                'a' => 'Les choix techniques dépendent du climat, des sols, du relief, des filières présentes et des débouchés économiques locaux.',
            ],
        ],
        'glossary' => [
            ['term' => 'Agroécologie', 'definition' => 'Application de principes écologiques à la production agricole.'],
            ['term' => 'Rotation', 'definition' => 'Alternance planifiée des cultures sur une même parcelle.'],
            ['term' => 'Circuit court', 'definition' => 'Vente avec peu ou pas d’intermédiaires.'],
            ['term' => 'Prairie permanente', 'definition' => 'Prairie installée durablement, utile à l’élevage et aux écosystèmes.'],
            ['term' => 'Autonomie fourragère', 'definition' => 'Capacité d’un élevage à produire la majorité de l’alimentation de ses animaux.'],
            ['term' => 'Couvert végétal', 'definition' => 'Culture implantée entre deux cultures principales pour protéger et enrichir le sol.'],
        ],
        'resources' => [
            ['title' => 'Visites pédagogiques', 'description' => 'Trouver des fermes ouvertes au public et aux écoles.'],
            ['title' => 'Formations et métiers', 'description' => 'Explorer les parcours liés à l’agriculture et l’agroalimentaire.'],
            ['title' => 'Consommation responsable', 'description' => 'Repères pratiques pour des achats plus durables.'],
            ['title' => 'Calendrier des marchés locaux', 'description' => 'Repérer les marchés de producteurs et points de vente à la ferme.'],
            ['title' => 'Aides et accompagnement', 'description' => 'Comprendre les dispositifs d’appui à la transition agroécologique.'],
            ['title' => 'Découvrir les labels', 'description' => 'Comparer les principaux labels qualité, origine et durabilité.'],
            ['title' => 'Boîte à outils anti-gaspillage', 'description' => 'Astuces pour mieux conserver, cuisiner et valoriser les produits frais.'],
            ['title' => 'Parcours pédagogiques', 'description' => 'Ressources pour enseignants et familles autour de l’alimentation et des saisons.'],
        ],
    ];
}
