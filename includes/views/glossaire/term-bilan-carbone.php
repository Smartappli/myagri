<?php
if (!is_array($selectedGlossaryTerm)) {
    $selectedGlossaryTerm = glossaryTermBySlug($glossary, 'bilan-carbone');
}
require __DIR__ . '/term-template.php';

