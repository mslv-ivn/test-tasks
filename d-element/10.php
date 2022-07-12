<?php
function minusNumber(&$num): void
{
    $num--;
    if ($num > 3) minusNumber($num);
}