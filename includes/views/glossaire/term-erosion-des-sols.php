<?php
if (!is_array($selectedGlossaryTerm)) {
    $selectedGlossaryTerm = glossaryTermBySlug($glossary, 'erosion-des-sols');
}
require __DIR__ . '/term-template.php';

