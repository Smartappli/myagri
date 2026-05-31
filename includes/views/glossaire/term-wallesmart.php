<?php
if (!is_array($selectedGlossaryTerm) || !isset($selectedGlossaryTerm['term']) || !is_string($selectedGlossaryTerm['term'])) {
    $selectedGlossaryTerm = glossaryTermBySlug($glossary, 'wallesmart');
} elseif (!isset($selectedGlossaryTerm['term']) || !is_string($selectedGlossaryTerm['term'])) {
    return;
}

if (!is_array($selectedGlossaryTerm)) {
    return;
}

$glossaryIntroduction = 'WALLeSmart designe un espace numerique de coordination des informations agricoles locales : echanges entre acteurs, outils pratiques et reperes pour agir concretement sur le territoire.';
$glossaryWhatToSee = [
    'Reperez les parcours numeriques utilises pour partager des pratiques ou des donnees locales.',
    'Observer comment la plateforme facilite la mise en relation entre fermes, services publics, formateurs et citoyens.',
    'Identifier les cas de usage en pedagogie, distribution de ressources et coherence territoriale.',
];
$glossaryWhyImportant = [
    'Il rend les initiatives plus lisibles et trace les actions de terrain.',
    'Il simplifie la circulation des informations utiles entre professionnels et publics.',
    'Il soutient la transition en orientant vers des ressources locales fiables.',
];
$glossaryActions = [
    'Utilisez le terme pour decrire les outils digitaux structures autour d un usage concret du territoire.',
    'Precisez le niveau d ouverture et les publics vises sur chaque usage (familles, ecoles, producteurs, collectivites).',
    'Croisez les actions numeriques avec des actions physiques locales pour une mise en oeuvre plus robuste.',
];

require __DIR__ . '/term-template.php';
