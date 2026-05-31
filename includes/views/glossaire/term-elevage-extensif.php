<?php
if (!is_array($selectedGlossaryTerm)) {
    $selectedGlossaryTerm = glossaryTermBySlug($glossary, 'elevage-extensif');
}
require __DIR__ . '/term-template.php';

