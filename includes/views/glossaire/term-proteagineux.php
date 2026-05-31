<?php
if (!is_array($selectedGlossaryTerm)) {
    $selectedGlossaryTerm = glossaryTermBySlug($glossary, 'proteagineux');
}
require __DIR__ . '/term-template.php';

