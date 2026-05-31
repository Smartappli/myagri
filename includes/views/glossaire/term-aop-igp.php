<?php
if (!is_array($selectedGlossaryTerm)) {
    $selectedGlossaryTerm = glossaryTermBySlug($glossary, 'aop-igp');
}
require __DIR__ . '/term-template.php';

