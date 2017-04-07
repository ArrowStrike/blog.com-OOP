<?php

/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 07-Apr-17
 * Time: 5:43
 */
class Comments
{
    public static function getCommentsToSidebar()
    {
        $db = Db::getConnection();
        $commentsList = array();
        $result = $db->query("SELECT * FROM comments ORDER BY id DESC LIMIT 5");
        $result->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $result->fetch()) {
            $commentsList[] = $row;
        }

        return $commentsList;
    }


}