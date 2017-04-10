<?php

class Articles
{
    public static function getArticleById($titleTranslit)
    {
        $db = Db::getConnection();
        $category = trim($titleTranslit);


        $result = $db->prepare("SELECT * FROM articles WHERE title_translit=" . "'$titleTranslit'");
        $result->execute([$category]);
        $result->setFetchMode(PDO::FETCH_ASSOC);

        $articleItem = $result->fetch();

        return $articleItem;
    }

    public static function incrementViews($articleID)
    {
        $db = Db::getConnection();
        $articleID = (int)$articleID;
        $db->query("UPDATE articles SET views = views + 1 WHERE id = " . $articleID);

        return true;
    }

    public static function getArticleList($perPage, $category = null, $offset = null)
    {
        $db = Db::getConnection();
        $category = trim($category);
        $articleList = array();

        if ($offset != null) {

            if ($category != null) {
                $result = $db->prepare("SELECT * FROM articles WHERE category_id=
                                  (SELECT id FROM articles_categories 
                                  WHERE title_translit=?) 
                                  ORDER BY id DESC LIMIT " . $offset . "," . $perPage);

                $result->execute([$category]);

            } else {
                $result = $db->query("SELECT * FROM articles ORDER BY id DESC LIMIT $offset,$perPage");

            }

        } else {
            if ($category != null) {
                $result = $db->prepare("SELECT * FROM articles WHERE category_id=
                                  (SELECT id FROM articles_categories 
                                  WHERE title_translit=?) 
                                  ORDER BY id DESC LIMIT " . $perPage);

                $result->execute([$category]);

            } else {
                $result = $db->query("SELECT * FROM articles ORDER BY id DESC LIMIT " . $perPage);
            }
        }
        $result->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $result->fetch()) {
            $articleList[] = $row;
        }

        return $articleList;
    }

    public static function getTotalCountOfArticle($category = null)
    {
        $db = Db::getConnection();
        $category = trim($category);

        if ($category != null) {
            $result = $db->prepare("SELECT COUNT(id) as total_count FROM articles WHERE category_id=
                                  (SELECT id FROM articles_categories 
                                  WHERE title_translit=?)");
            $result->execute([$category]);
        } else {
            $result = $db->query("SELECT COUNT(id) as total_count FROM articles");
        }

        $result->setFetchMode(PDO::FETCH_ASSOC);

        $totalCount = $result->fetch();
        $totalCount = $totalCount['total_count'];

        return $totalCount;
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
        $id = (int)$id;

        $result = $db->query("SELECT title_translit FROM articles WHERE id=" . $id);

        $result = $result->fetch();

        $result = $result['title_translit'];

        return $result;
    }


}