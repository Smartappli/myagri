<?php
if (!is_array($selectedGlossaryTerm)) {
    $selectedGlossaryTerm = glossaryTermBySlug($glossary, 'prairie-permanente');
}
require __DIR__ . '/term-template.php';

