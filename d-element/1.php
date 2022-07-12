<?php
function sum_string($arr): string
{
    $array = $arr;
    $s_keys = '';
    $values = 0;
    foreach ($array as $key => $value) {
        $s_keys .= $key." ";
        $values += $value*13;
    }
    return $s_keys.$values;
}

$arr = ["a" => 12, "b" => 2, "c" => 4];
echo sum_string($arr);