<?php
if (!is_array($selectedGlossaryTerm) || !isset($selectedGlossaryTerm['term']) || !is_string($selectedGlossaryTerm['term'])) {
    $selectedGlossaryTerm = glossaryTermBySlug($glossary, 'wallesmart');
} elseif (!isset($selectedGlossaryTerm['term']) || !is_string($selectedGlossaryTerm['term'])) {
    return;
}

if (!is_array($selectedGlossaryTerm)) {
    return;
}

$glossaryIntroduction = 'WALLeSmart désigne un espace numérique de coordination des informations agricoles locales : échanges entre acteurs, outils pratiques et repères pour agir concrètement sur le territoire.';
$glossaryWhatToSee = [
    'Repérez les parcours numériques utilisés pour partager des pratiques ou des données locales.',
    'Observer comment la plateforme facilite la mise en relation entre fermes, services publics, formateurs et citoyens.',
    'Identifier les cas d\'usage en pédagogie, distribution de ressources et cohérence territoriale.',
];
$glossaryWhyImportant = [
    'Il rend les initiatives plus lisibles et trace les actions de terrain.',
    'Il simplifie la circulation des informations utiles entre professionnels et publics.',
    'Il soutient la transition en orientant vers des ressources locales fiables.',
];
$glossaryActions = [
    'Utilisez le terme pour décrire les outils digitaux structurés autour d\'un usage concret du territoire.',
    'Précisez le niveau d\'ouverture et les publics visés sur chaque usage (familles, écoles, producteurs, collectivités).',
    'Croisez les actions numériques avec des actions physiques locales pour une mise en œuvre plus robuste.',
];

require __DIR__ . '/term-template.php';
