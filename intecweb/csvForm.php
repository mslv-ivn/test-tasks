<?php
require 'MysqlCsv.php';

$_SESSION["user_id"] = 1000;

if(isset($_POST['import']))
{
    if (!empty($_FILES['importFile']['name']))
    {
        $MysqlCsv = new MysqlCsv();
        $result = $MysqlCsv->import($_FILES['importFile']['tmp_name']);
        echo $result;
    }
}
if(isset($_POST['export']))
{
    $MysqlCsv = new MysqlCsv();
    $MysqlCsv->export();
}