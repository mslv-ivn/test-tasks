<?php
$login = "login";
$password = "password";

if ($_POST["login"] == $login && $_POST["password"] == $password) {
    session_start();
    $_SESSION['LOGIN'] = 'YES';
}