<?php
if (!is_array($selectedGlossaryTerm)) {
    $selectedGlossaryTerm = glossaryTermBySlug($glossary, 'zero-artificialisation-nette-zan');
}
require __DIR__ . '/term-template.php';

