<?php
if (!is_array($selectedGlossaryTerm)) {
    $selectedGlossaryTerm = glossaryTermBySlug($glossary, 'gestion-integree-des-ravageurs');
}
require __DIR__ . '/term-template.php';

