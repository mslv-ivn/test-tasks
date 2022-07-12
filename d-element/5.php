<?php
function checkCreateElement($value): string
{
    $amount = intdiv($value,7);
    $remainder = fmod($value,7) * 1000000;
    return !$remainder ? "Создано '$amount' штук" : "Создано '$amount' штук, остаток - '$remainder' грамм";
}