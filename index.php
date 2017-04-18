<?php
//FRONT CONTROLLER (index.php)


//1. Общие настройки
ini_set('display_errors', 1);
error_reporting(E_ALL);

//2. Подключение файлов системы
define('ROOT', dirname(__FILE__));//ROOT - полный путь к корневой папке на диске
require_once (ROOT.'/components/Autoload.php');
$GLOBALS['DB'] = Db::getConnection();

//3. Вызов Router
$router = new Router();
$router->run();
