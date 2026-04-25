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
            ['name' => 'Produire', 'description' => 'Assurer une production fiable et diversifiée.'],
            ['name' => 'Préserver', 'description' => 'Protéger eau, sol, climat et biodiversité.'],
            ['name' => 'Relier', 'description' => 'Créer du lien entre producteurs et citoyens.'],
            ['name' => 'Innover', 'description' => 'S’appuyer sur la recherche et les pratiques de terrain.'],
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
                ],
                'public_actions' => [
                    'Privilégier la saisonnalité et l’origine locale.',
                    'S’informer sur les filières de transformation régionales.',
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
                ],
                'public_actions' => [
                    'Découvrir les labels et démarches qualité.',
                    'Soutenir les points de vente fermiers.',
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
                ],
                'public_actions' => [
                    'Acheter en direct chez les producteurs.',
                    'Diversifier son panier avec des produits de saison.',
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
                ],
                'public_actions' => [
                    'Découvrir les produits locaux transformés (jus, bière, vin, confitures).',
                    'Visiter les exploitations qui ouvrent leurs ateliers au public.',
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
            ['name' => 'Brabant wallon', 'profile' => 'Mosaïque de cultures, maraîchage et transformation locale.'],
            ['name' => 'Hainaut', 'profile' => 'Poids important des grandes cultures et de l’agroalimentaire.'],
            ['name' => 'Liège', 'profile' => 'Élevage, vergers et filières de valorisation de proximité.'],
            ['name' => 'Luxembourg', 'profile' => 'Systèmes herbagers, forêts et élevage extensif.'],
            ['name' => 'Namur', 'profile' => 'Diversité de productions entre grandes cultures, élevage et maraîchage.'],
        ],
        'seasonalCalendar' => [
            ['season' => 'Printemps', 'focus' => 'Semis, gestion de l’eau, protection contre le gel tardif.'],
            ['season' => 'Été', 'focus' => 'Récoltes précoces, irrigation ciblée, prévention du stress hydrique.'],
            ['season' => 'Automne', 'focus' => 'Récoltes principales, semis d’automne, couverts végétaux.'],
            ['season' => 'Hiver', 'focus' => 'Entretien du matériel, planification, soins aux animaux.'],
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
        ],
    ];
}
