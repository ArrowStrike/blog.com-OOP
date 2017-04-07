<?php

return array(
    //   запрос что набирает пользователь/строка по которой мы узнаем, где обрабатывается запрос
//  'category/([0-9]+)-([0-9a-z_]+)'=>'category/view/$1',

    'aboutMe'=> 'aboutMe/index',
    'copyright'=> 'copyright/index',
    'search?q=(.*)'=> 'articles/search/$1',
    'article/([0-9a-z_]+)'=> 'article/index/$1',

    'articles/page-([0-9]+)' => 'articles/$1', // actionCategory в CatalogController
    'articles' => 'articles/index', //будет вызван метод actionIndex в контроллере ArticlesController

    '([0-9a-z_]+)/page-([0-9]+)' => 'articles/category/$1/$2', // actionCategory в CatalogController
    '([0-9a-z_]+)'=>'articles/index/$1',


    ''=>'site/index',
    //  'products' => 'products/list', //actionList в контроллере ProductController


);