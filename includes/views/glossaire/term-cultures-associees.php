<?php
if (!is_array($selectedGlossaryTerm)) {
    $selectedGlossaryTerm = glossaryTermBySlug($glossary, 'cultures-associees');
}
require __DIR__ . '/term-template.php';

