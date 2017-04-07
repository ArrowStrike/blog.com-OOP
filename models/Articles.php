<?php

class Articles
{
    public static function getArticleById($id)
    {
        $db = Db::getConnection();
        $id = (int)$id;

        $result = $db->query("SELECT * FROM articles WHERE id=" . $id);
        $result->setFetchMode(PDO::FETCH_ASSOC);

        $articleItem = $result->fetch();

        return $articleItem;

    }

    public static function getArticleList($category=null)
    {
        $db = Db::getConnection();
        $category = trim($category);
        $articleList = array();

        if ($category!=null) {
            $result = $db->prepare("SELECT * FROM articles WHERE category_id=(SELECT id FROM articles_categories WHERE title_translit=?) ORDER BY id DESC LIMIT 10");
            $result->execute([$category]);

            // $result = $db->query("SELECT * FROM articles WHERE category_id=(SELECT id FROM articles_categories WHERE title_translit=?) ORDER BY id DESC LIMIT 10");

        } else {
            $result = $db->query("SELECT * FROM articles ORDER BY id DESC LIMIT 10");
        }
        $result->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $result->fetch()) {
            $articleList[] = $row;
        }

        return $articleList;
    }

    public static function getArticleToSidebar()
    {
        $db = Db::getConnection();
        $articleList = array();
        $result = $db->query("SELECT * FROM articles ORDER BY views DESC LIMIT 5");
        $result->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $result->fetch()) {
            $articleList[] = $row;
        }

        return $articleList;
    }


    public static function getTitleTranslitOfArticle($id)
    {
        $db = Db::getConnection();
        $id=(int)$id;

        $result = $db->query("SELECT title_translit FROM articles WHERE id=".$id);

        $result = $result->fetch();

        $result = $result['title_translit'];

        return $result;
    }
    /* public static function switchFunction($getFunction){
         switch ($status) {
             case '1':
                 return 'Отображается';
                 break;
             case '0':
                 return 'Скрыта';
                 break;
         }
     }*/

    public static function searchArticle()
    {
        $db = Db::getConnection();
        $articleList = array();
    }


}