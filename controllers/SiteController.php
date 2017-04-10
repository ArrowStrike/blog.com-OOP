<?php

class SiteController
{
    public function actionIndex()
    {
        $categories = Category::getCategoryList();
        $articleList = Articles::getArticleList(8);
        $articleToSidebar = Articles::getArticleToSidebar();
        $commentsToSidebar = Comments::getCommentsToSidebar();
        require_once(ROOT . '/views/site/index.php');
        return true;
    }
}
