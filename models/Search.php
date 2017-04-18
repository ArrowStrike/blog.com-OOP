<?php

/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 09-Apr-17
 * Time: 19:20
 */
class Search
{
    public static function getSearchList($perPage, $offset = null)
    {
        $matchFound = null;

        $keyWord = self::getKeyWord();

        if (!empty($keyWord)) {
            if (mb_strlen($keyWord) < 3) {
                $articleList = '<p>Слишком короткий поисковый запрос.</p>';
            } else if (mb_strlen($keyWord) > 128) {
                $articleList = '<p>Слишком длинный поисковый запрос.</p>';
            } else {
                $result = $GLOBALS['DB']->prepare("SELECT *
                  FROM articles WHERE title LIKE '%$keyWord%'
                  OR text LIKE '%$keyWord%' LIMIT $offset,$perPage");

                $result->execute();
                $result->setFetchMode(PDO::FETCH_ASSOC);


                if ($result->rowCount() > 0) {

                    $articleList = array();

                    while ($row = $result->fetch()) {
                        $articleList[] = $row;
                    }
                } else {
                    $articleList = '<p>По запросу "' . $keyWord . '" ниодной статьи не найдено.</p>';
                }
            }
        } else {
            $articleList = '<p>Задан пустой поисковый запрос.</p>';
        }

        return $articleList;
    }

    public static function getTotalCountOfSearch($keyWord)
    {
        $result = $GLOBALS['DB']->prepare("SELECT COUNT(id) AS total_count 
                    FROM articles WHERE title LIKE '%$keyWord%'
                    OR text LIKE '%$keyWord%'");
        $result->execute();

        $result->setFetchMode(PDO::FETCH_ASSOC);

        $totalCount = $result->fetch();
        $totalCount = $totalCount['total_count'];

        return $totalCount;
    }

    public static function resultMessage($articleList, $total, $keyWord)
    {
        if (!is_array($articleList)) {
            echo $articleList;
        } else {
            echo '<p>По запросу "<b>' . $keyWord . '</b>"  найдено совпадений: ' . $total . '</p>';
        }
    }

    public static function getKeyWord()
    {

        if (isset($_GET['q'])) {
            $keyWord = explode('/', $_GET['q']);

            $deletion = array_pop($keyWord);


            if (preg_match('(page-[0-9]+)', $deletion)) {
                $keyWord = implode('/', $keyWord);

            } else {
                $keyWord = implode('/', $keyWord) . $deletion;
            }
            return $keyWord;
        }
    }
}