<?php
if (!is_array($selectedGlossaryTerm)) {
    $selectedGlossaryTerm = glossaryTermBySlug($glossary, 'economie-circulaire');
}
require __DIR__ . '/term-template.php';

