<?php
if (!is_array($selectedGlossaryTerm)) {
    $selectedGlossaryTerm = glossaryTermBySlug($glossary, 'plan-de-fumure');
}
require __DIR__ . '/term-template.php';

