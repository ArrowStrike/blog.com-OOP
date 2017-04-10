<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 18-Mar-17
 * Time: 14:56
 */
require_once "database.php";
require_once "functions.php";
session_start();

$link = db_connect();
$email = htmlspecialchars($_POST["email"]);
$password = htmlspecialchars($_POST["password"]);
//$password = password_hash($password, PASSWORD_DEFAULT);

if (checkUser($link, $email, $password)) {
    $_SESSION["email"] = $email;
    $_SESSION["password"] = $password;
} else {
    $_SESSION["error_auth"] = 1;
}

redirect($_SERVER["HTTP_REFERER"]);
exit;