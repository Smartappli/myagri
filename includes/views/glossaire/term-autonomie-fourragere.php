<?php
if (!is_array($selectedGlossaryTerm)) {
    $selectedGlossaryTerm = glossaryTermBySlug($glossary, 'autonomie-fourragere');
}
require __DIR__ . '/term-template.php';

