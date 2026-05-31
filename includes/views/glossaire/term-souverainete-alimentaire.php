<?php
if (!is_array($selectedGlossaryTerm)) {
    $selectedGlossaryTerm = glossaryTermBySlug($glossary, 'souverainete-alimentaire');
}
require __DIR__ . '/term-template.php';

