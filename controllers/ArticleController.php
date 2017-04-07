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
    public function actionIndex($id)
    {
        if ($id){
            $articleItem = Articles::getArticleById($id);
        }
        return true;
    }
}