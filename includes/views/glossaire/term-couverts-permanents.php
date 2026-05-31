<?php
if (!is_array($selectedGlossaryTerm)) {
    $selectedGlossaryTerm = glossaryTermBySlug($glossary, 'couverts-permanents');
}
require __DIR__ . '/term-template.php';

