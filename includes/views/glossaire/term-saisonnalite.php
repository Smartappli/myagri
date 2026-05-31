<?php
if (!is_array($selectedGlossaryTerm)) {
    $selectedGlossaryTerm = glossaryTermBySlug($glossary, 'saisonnalite');
}
require __DIR__ . '/term-template.php';

