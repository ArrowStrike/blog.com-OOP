<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 18-Mar-17
 * Time: 17:45
 */
session_start();
unset($_SESSION);
session_destroy();
header('Location: ../views/authPage.php');