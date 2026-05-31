<?php
if (!is_array($selectedGlossaryTerm)) {
    $selectedGlossaryTerm = glossaryTermBySlug($glossary, 'transformation-a-la-ferme');
}
require __DIR__ . '/term-template.php';

