<?php
if (!is_array($selectedGlossaryTerm)) {
    $selectedGlossaryTerm = glossaryTermBySlug($glossary, 'matiere-organique');
}
require __DIR__ . '/term-template.php';

