<?php
if (!is_array($selectedGlossaryTerm)) {
    $selectedGlossaryTerm = glossaryTermBySlug($glossary, 'agriculture-biologique');
}
require __DIR__ . '/term-template.php';

