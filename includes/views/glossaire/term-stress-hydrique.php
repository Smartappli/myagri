<?php
if (!is_array($selectedGlossaryTerm)) {
    $selectedGlossaryTerm = glossaryTermBySlug($glossary, 'stress-hydrique');
}
require __DIR__ . '/term-template.php';

