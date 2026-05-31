<?php
if (!is_array($selectedGlossaryTerm)) {
    $selectedGlossaryTerm = glossaryTermBySlug($glossary, 'circuit-court');
}
require __DIR__ . '/term-template.php';

