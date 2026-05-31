<?php
if (!is_array($selectedGlossaryTerm)) {
    $selectedGlossaryTerm = glossaryTermBySlug($glossary, 'agriculture-de-precision');
}
require __DIR__ . '/term-template.php';

