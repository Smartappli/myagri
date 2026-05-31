<?php
if (!is_array($selectedGlossaryTerm)) {
    $selectedGlossaryTerm = glossaryTermBySlug($glossary, 'agroecologie');
}
require __DIR__ . '/term-template.php';

