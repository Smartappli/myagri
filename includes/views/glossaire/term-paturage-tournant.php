<?php
if (!is_array($selectedGlossaryTerm)) {
    $selectedGlossaryTerm = glossaryTermBySlug($glossary, 'paturage-tournant');
}
require __DIR__ . '/term-template.php';

