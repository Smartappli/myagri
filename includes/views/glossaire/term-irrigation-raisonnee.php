<?php
if (!is_array($selectedGlossaryTerm)) {
    $selectedGlossaryTerm = glossaryTermBySlug($glossary, 'irrigation-raisonnee');
}
require __DIR__ . '/term-template.php';

