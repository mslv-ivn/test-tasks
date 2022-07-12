<?php
function checkFunc($value): bool|string
{
    if(is_string($value))
        return false;
    return $value > 170 ? "Big" : "Small";
}