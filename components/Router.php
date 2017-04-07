<?php

class Router
{


    private $routes; //массив в котором будут храниться маршруты

    public function __construct()
    {
        $routesPath = ROOT . '/config/routes.php'; // указываем путь к роутам
        $this->routes = include($routesPath); // присваиваем свойству routes массив в файле routes.php
    }

    private function getURI()//Returns request string
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function run()//анализирует запрос и принимает управление от front controllera
    {


        //Получаем строку запроса
        $uri = $this->getURI();
        //Проверить наличие такого запроса в routes.php
        foreach ($this->routes as $uriPattern => $path){
           //Сравниваем $uriPattern и $uri
            if (preg_match("~$uriPattern~", $uri)){ //~ вместо / ,так как могут быть и сплеши в адресе


                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);//в строке запроса, ищем параметры "спорт/114", если находим, то в подставляем строку Path articles/view/$1/$2 и получим внутренний маршрут
                //Если есть совпадение, определить какой контроллер и action и параметр обрабатывают запрос

                $segments = explode('/', $internalRoute); // для того, что бы разделить строку на две части - контроллер и action

                $controllerName = array_shift($segments).'Controller';//получает первый элемент массива и удаляет его из массива (получает controller)
                $controllerName = ucfirst($controllerName); //делает первую букву строки заглавной

                $actionName = 'action'.ucfirst(array_shift($segments));//получает Action

                $parameters = $segments;//массив с параметрами //$1, $2, $3...

                ////Подключить файл класса-контроллера
                $controllerFile = ROOT.'/controllers/'.
                    $controllerName . '.php';

                if (file_exists($controllerFile)){ //проверяем, существует ли такой файл на диске
                    include_once $controllerFile;
                }


                //Создать обьект, вызвать метод (т.е action)
                $controllerObject = new $controllerName;
                //вызывает экшон, который находится в переменной actionName у обьекта controllerObject(NewsController), при этом передает ему массив с параметрами
                $result = call_user_func_array(array($controllerObject, $actionName), $parameters);


                if ($result != null){
                    break;
                }

            }
        }





    }
}