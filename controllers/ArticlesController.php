<?php

/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 04-Apr-17
 * Time: 23:35
 */
class ArticlesController
{
    //'Список статей';
    public function actionIndex($category=null)
    {
        $categories = Category::getCategoryList();
        $articleList = Articles::getArticleList($category);
        $articleToSidebar = Articles::getArticleToSidebar();
        $commentsToSidebar= Comments::getCommentsToSidebar();
        require_once(ROOT . '/views/articles/index.php');
        return true;
    }

    public function actionSearch($query)
    {
        if ($query) {
            $searchResult = Articles::searchArticle($query);
            require_once(ROOT . '/views/articles/index.php');
        }
        return true;
    }

}