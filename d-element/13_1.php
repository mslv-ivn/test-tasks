<?php
$id = $_POST['product_id'];

session_start();
if (isset($_SESSION["cart"][$id])) {
    $_SESSION["cart"][$id]++;
} else {
    $_SESSION["cart"][$id] = 1;
}
echo $_SESSION["cart"][$id];