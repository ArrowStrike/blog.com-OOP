<?php

/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 07-Apr-17
 * Time: 2:51
 */
class CopyrightController
{
    public function actionIndex()
    {
        $categories = Category::getCategoryList();
        $articleToSidebar = Articles::getArticleToSidebar();
        $commentsToSidebar = Comments::getCommentsToSidebar();
        require_once(ROOT . '/views/copyright/index.php');
    }
}