<?php

/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 07-Apr-17
 * Time: 3:50
 */
class Functions
{

    public static function translit($title)
    {

        static $converter = array(
            'а' => 'a', 'б' => 'b', 'в' => 'v',
            'г' => 'g', 'д' => 'd', 'е' => 'e',
            'ё' => 'e', 'ж' => 'zh', 'з' => 'z',
            'и' => 'i', 'й' => 'y', 'к' => 'k',
            'л' => 'l', 'м' => 'm', 'н' => 'n',
            'о' => 'o', 'п' => 'p', 'р' => 'r',
            'с' => 's', 'т' => 't', 'у' => 'u',
            'ф' => 'f', 'х' => 'h', 'ц' => 'c',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
            'ы' => 'y',
            'э' => 'e', 'ю' => 'yu', 'я' => 'ya',

            'А' => 'A', 'Б' => 'B', 'В' => 'V',
            'Г' => 'G', 'Д' => 'D', 'Е' => 'E',
            'Ё' => 'E', 'Ж' => 'Zh', 'З' => 'Z',
            'И' => 'I', 'Й' => 'Y', 'К' => 'K',
            'Л' => 'L', 'М' => 'M', 'Н' => 'N',
            'О' => 'O', 'П' => 'P', 'Р' => 'R',
            'С' => 'S', 'Т' => 'T', 'У' => 'U',
            'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
            'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sch',
            'Ы' => 'Y',
            'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
        );

        $converted = strtr($title, $converter);
        $converted = strtolower($converted);
        $converted = preg_replace("/[\s]/", "-", $converted);
        $converted = preg_replace("/[^a-z0-9-]/", "", $converted);
        return $converted;

    }

    public static function appropriateCategory($categories, $id)
    {
        $artCategory = false;
        foreach ($categories as $cat) {
            if ($cat['id'] === $id) {
                $artCategory = $cat;
                break;
            }
        }
        return $artCategory;
    }

    public static function introArticle($text, $size)
    {
        $textSize = mb_strlen($text);
        if ($textSize > $size) {
            $text = mb_substr($text, 0, $size);
            $words2 = explode(' ', $text);
            array_pop($words2);
            echo implode(' ', $words2) . '...';
        } else
            echo $text;
    }

}
