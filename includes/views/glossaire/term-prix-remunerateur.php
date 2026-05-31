<?php
if (!is_array($selectedGlossaryTerm)) {
    $selectedGlossaryTerm = glossaryTermBySlug($glossary, 'prix-remunerateur');
}
require __DIR__ . '/term-template.php';

