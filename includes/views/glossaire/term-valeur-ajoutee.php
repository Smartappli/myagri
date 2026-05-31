<?php
if (!is_array($selectedGlossaryTerm)) {
    $selectedGlossaryTerm = glossaryTermBySlug($glossary, 'valeur-ajoutee');
}
require __DIR__ . '/term-template.php';

