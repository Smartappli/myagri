<?php
if (!is_array($selectedGlossaryTerm)) {
    $selectedGlossaryTerm = glossaryTermBySlug($glossary, 'polyculture-elevage');
}
require __DIR__ . '/term-template.php';

