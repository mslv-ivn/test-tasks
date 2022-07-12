<?php
function Pyramid($n): string
{
    $string = '';
    for ($i = 0; $i < $n; $i++) {
        $string .=  str_repeat($i, $i+1)."</br>";
    }
    return $string;
}