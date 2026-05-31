<?php
if (!is_array($selectedGlossaryTerm)) {
    $selectedGlossaryTerm = glossaryTermBySlug($glossary, 'agroforesterie');
}
require __DIR__ . '/term-template.php';

