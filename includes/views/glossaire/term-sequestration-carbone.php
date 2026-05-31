<?php
if (!is_array($selectedGlossaryTerm)) {
    $selectedGlossaryTerm = glossaryTermBySlug($glossary, 'sequestration-carbone');
}
require __DIR__ . '/term-template.php';

