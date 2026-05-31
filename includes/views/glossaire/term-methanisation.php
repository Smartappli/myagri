<?php
if (!is_array($selectedGlossaryTerm)) {
    $selectedGlossaryTerm = glossaryTermBySlug($glossary, 'methanisation');
}
require __DIR__ . '/term-template.php';

