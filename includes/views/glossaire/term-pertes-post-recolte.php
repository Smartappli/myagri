<?php
if (!is_array($selectedGlossaryTerm)) {
    $selectedGlossaryTerm = glossaryTermBySlug($glossary, 'pertes-post-recolte');
}
require __DIR__ . '/term-template.php';

