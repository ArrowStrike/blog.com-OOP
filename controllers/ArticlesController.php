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
    public function actionIndex($category = null, $page = 1)
    {
        $categories = Category::getCategoryList();
        if ($page == 0) {
            $page = 1;
        }
        $offset = (Configs::getConfig('articlePerPage') * $page) - Configs::getConfig('articlePerPage'); //сдвиг
        $articleList = Articles::getArticleList(Configs::getConfig('articlePerPage'), $category, $offset);

        // Общее количетсво статей (необходимо для постраничной навигации)
        $total = Articles::getTotalCountOfArticle($category);

        // Создаем объект Pagination - постраничная навигация
        $pagination = new Pagination($total, $page, Configs::getConfig('articlePerPage'), 'page-');

        $articleToSidebar = Articles::getArticleToSidebar();
        $commentsToSidebar = Comments::getCommentsToSidebar();

        require_once(ROOT . '/views/articles/index.php');
        return true;
    }


    public function actionSearch($page = 1)
    {

        if ($_GET['q']) {
            $categories = Category::getCategoryList();
            if ($page == 0) {
                $page = 1;
            }
            $offset = (Configs::getConfig('articlePerPage') * $page) - Configs::getConfig('articlePerPage'); //сдвиг
            $articleList = Search::getSearchList(Configs::getConfig('articlePerPage'), $offset);

            $keyWord = Search::getKeyWord();
            $total = Search::getTotalCountOfSearch($keyWord);
            $pagination = new Pagination($total, $page, Configs::getConfig('articlePerPage'), 'page-');

            $articleToSidebar = Articles::getArticleToSidebar();
            $commentsToSidebar = Comments::getCommentsToSidebar();

            require_once(ROOT . '/views/articles/index.php');
        }
        return true;
    }

}