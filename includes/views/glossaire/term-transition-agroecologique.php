<?php
if (!is_array($selectedGlossaryTerm)) {
    $selectedGlossaryTerm = glossaryTermBySlug($glossary, 'transition-agroecologique');
}
require __DIR__ . '/term-template.php';

