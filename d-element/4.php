<?php
function HowManyBetween($val1, $val2): float|int|string
{
    if(!is_numeric($val1) || !is_numeric($val2))
        return "Значение должно быть числом";
    return $val1 > $val2 ? $val1 - $val2 : $val2 - $val1;
}