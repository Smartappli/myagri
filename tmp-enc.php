<?php
function f($s){
    $a = mb_convert_encoding($s, 'UTF-8', 'ISO-8859-1');
    $b = mb_convert_encoding($s, 'UTF-8', 'Windows-1252');
    echo "$s\nISO=$a\nWIN=$b\n";
}
f('Agroécologie');
f('AgroÃ©cologie');
f('économie');
f('Ã©conomie');
