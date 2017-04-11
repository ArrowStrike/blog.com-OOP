<?php

/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 07-Apr-17
 * Time: 2:51
 */
class ArticleController
{
    //"Просмотре одной новости";
    public function actionIndex($titleTranslit)
    {
        if ($titleTranslit) {
            $categories = Category::getCategoryList();
            $articleToSidebar = Articles::getArticleToSidebar();
            $articleItem = Articles::getArticleById($titleTranslit);
            Articles::incrementViews($articleItem['id']);
            $logsOfValidation = Comments::commentsValidator($articleItem['id']);
            $commentsToSidebar = Comments::getCommentsToSidebar();
            $commentsList = Comments::getComments($articleItem['id']);

            require_once(ROOT . '/views/article/index.php');
        };
    }
}
