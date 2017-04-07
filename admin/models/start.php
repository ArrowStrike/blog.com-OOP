<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 18-Mar-17
 * Time: 14:42
 */
session_start();
require_once "functions.php";
require_once "database.php";
$link = db_connect();
if (!((checkUser($link, $_SESSION["email"], $_SESSION["password"])) && (isAdmin($link,$_SESSION["email"])))) {
    redirect("/admin/views/authPage.php");
    exit;
}