<?php
if (!is_array($selectedGlossaryTerm)) {
    $selectedGlossaryTerm = glossaryTermBySlug($glossary, 'fertilite-du-sol');
}
require __DIR__ . '/term-template.php';

