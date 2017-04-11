<?php
//FRONT CONTROLLER (index.php)


//1. Общие настройки
ini_set('display_errors', 1);
error_reporting(E_ALL);

//2. Подключение файлов системы
define('ROOT', dirname(__FILE__));//полный путь к файлу на диске
require_once (ROOT.'/components/Db.php');
$GLOBALS['CONNECTION'] = Db::getConnection();

require_once (ROOT.'/components/Autoload.php');

//3. Вызов Router
$router = new Router();
$router->run();
