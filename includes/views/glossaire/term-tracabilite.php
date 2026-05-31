<?php
if (!is_array($selectedGlossaryTerm)) {
    $selectedGlossaryTerm = glossaryTermBySlug($glossary, 'tracabilite');
}
require __DIR__ . '/term-template.php';

