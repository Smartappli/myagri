<?php
if (!is_array($selectedGlossaryTerm)) {
    $selectedGlossaryTerm = glossaryTermBySlug($glossary, 'haie-vive');
}
require __DIR__ . '/term-template.php';

