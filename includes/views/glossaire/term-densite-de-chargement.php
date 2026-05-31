<?php
if (!is_array($selectedGlossaryTerm)) {
    $selectedGlossaryTerm = glossaryTermBySlug($glossary, 'densite-de-chargement');
}
require __DIR__ . '/term-template.php';

