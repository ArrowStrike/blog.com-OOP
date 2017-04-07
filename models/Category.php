<?php

class Category
{
    public static function getCategoryList()
    {
        $db = Db::getConnection();
        $result = $db->query("SELECT * FROM articles_categories ORDER BY id");
        $result->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $result->fetch()) {
            $categories[] = $row;
        }

        return $categories;
    }
}