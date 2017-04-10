<?php

class Router
{


    private $routes; //массив в котором будут храниться маршруты

    public function __construct()
    {
        // указываем путь к роутам
        $routesPath = ROOT . '/config/routes.php';

        // присваиваем свойству routes массив в файле routes.php
        $this->routes = include($routesPath);
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
        foreach ($this->routes as $uriPattern => $path) {
            //Сравниваем $uriPattern и $uri
            if (preg_match("~$uriPattern~", $uri)) { //~ вместо / ,так как могут быть и сплеши в адресе

                //в строке запроса, ищем параметры "спорт/114",
                // если находим, то подставляем в строку Path articles/view/$1/$2 и получим внутренний маршрут
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);

                //для того, что бы разделить строку на две части - контроллер и action
                $segments = explode('/', $internalRoute);

                //получает первый элемент массива и удаляет его из массива (получает controller)
                $controllerName = array_shift($segments) . 'Controller';

                //делает первую букву строки заглавной
                $controllerName = ucfirst($controllerName);

                //получает Action
                $actionName = 'action' . ucfirst(array_shift($segments));

                //массив с параметрами //$1, $2, $3...
                $parameters = $segments;

                ////Подключить файл класса-контроллера
                $controllerFile = ROOT . '/controllers/' .
                    $controllerName . '.php';

                //проверяем, существует ли такой файл на диске
                if (file_exists($controllerFile)) {
                    include_once $controllerFile;
                }

                //Создать обьект, вызвать метод (т.е action)
                $controllerObject = new $controllerName;

                //вызывает экшон, который находится в переменной actionName у обьекта controllerObject(NewsController),
                // при этом передает ему массив с параметрами
                $result = call_user_func_array(array($controllerObject, $actionName), $parameters);


                if ($result != null) {
                    break;
                }

            }
        }


    }
}