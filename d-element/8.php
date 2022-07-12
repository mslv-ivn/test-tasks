<?php
function checkValue($arr, $str): int|string|null
{
    foreach ($arr as $key => $value) {
        if($value == $str) return $key;
    }
    return null;
}