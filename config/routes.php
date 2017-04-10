<?php

return array(
    //   запрос что набирает пользователь/строка по которой мы узнаем, где обрабатывается запрос
    // => controller / action


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