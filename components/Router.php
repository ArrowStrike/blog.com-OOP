<?php

class Router
{
    //массив в котором будут храниться маршруты
    private $routes = array(

        //   запрос что набирает пользователь/строка по которой мы узнаем, где обрабатывается запрос
        //        => controller / action / params(name or page)

        'aboutMe' => 'aboutMe/index',
        'copyright' => 'copyright/index',

        //поиск
        'search(.*)/page-([0-9]+)' => 'articles/search/$2',
        'search(.*)' => 'articles/search',

        //страница статьи
        'article/([0-9a-z_]+)' => 'article/index/$1',

        //страница всех стетей
        'articles/page-([0-9]+)' => 'articles/index//$1',
        'articles' => 'articles/index',

        //категории
        '([0-9a-z_]+)/page-([0-9]+)' => 'articles/index/$1/$2',
        '(.+)' => 'articles/index/$1',

        //начальная страница
        '' => 'site/index',
    );


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

        //Проверить наличие такого запроса в массиве routes
        foreach ($this->routes as $uriPattern => $path) {
            //Сравниваем $uriPattern и $uri
            if (preg_match("~$uriPattern~", $uri)) { //~ вместо / ,так как могут быть и сплеши в адресе

                //в строке запроса, ищем параметры "sport/114",
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

                //вызывает экшон, который находится в переменной actionName у обьекта controllerObject(Controller),
                // при этом передает ему массив с параметрами
                call_user_func_array(array($controllerObject, $actionName), $parameters);

                if (method_exists($controllerObject, $actionName)) {
                    break;
                }
            }
        }
    }
}