<?php
function allArticles($link)
{
    $page = 1;
    $countOfArticlesPerPage = 8;
    if (isset($_GET['page'])) {
        $page = (int)$_GET['page'];
    }
    $offset = ($countOfArticlesPerPage * $page) - $countOfArticlesPerPage; //сдвиг


// Формируем запрос
    $query = "SELECT title, pubdate, image, id, category_id 
              FROM articles ORDER BY id DESC LIMIT $offset,$countOfArticlesPerPage";
    $result = mysqli_query($link, $query);

    if (!$result)
        die(mysqli_error($link));

// Извлекаем данные
    $n = mysqli_num_rows($result);
    $articles = array();

    for ($i = 0; $i < $n; $i++) {
        $row = mysqli_fetch_assoc($result);
        $articles[] = $row;
    }
    $totalCount = 0;//количество записей(статей)
    $totalCountArticles = mysqli_query($link, "SELECT COUNT(id) AS total_count FROM articles");
    $totalCount = mysqli_fetch_assoc($totalCountArticles);
    $totalCount = $totalCount['total_count'];
    $totalPages = ceil($totalCount / $countOfArticlesPerPage);
    if ($page <= 1 || $page > $totalPages) {
        $page = 1;
    }
    $articles[0]['page'] = $page;
    $articles[0]['totalPages'] = $totalPages;

    return $articles;
}

function getArticle($link, $id)
{
    $query = sprintf("SELECT id, title, text, image, category_id FROM articles WHERE id=%d", (int)$id);
    $result = mysqli_query($link, $query);

    if (!$result)
        die(mysqli_error($link));

    $article = mysqli_fetch_assoc($result);

    return $article;
}

function newArticle($link, $category_id, $title, $image, $text)
{
// Подготовка
    $title = trim($title);
    $title_translit = translit($title);
    $image = trim($image);
    $text = trim($text);
    $category_id = (int)$category_id;
// Проверка
    if ($title == '')
        return false;

// Запрос
    $templateAdd = "INSERT INTO articles (title, title_translit, category_id, pubdate, image, text) 
                    VALUES ('%s','%s','%d', NOW(), '%s', '%s')";

    $query = sprintf($templateAdd,
        mysqli_real_escape_string($link, $title),
        mysqli_real_escape_string($link, $title_translit),
        $category_id,
        mysqli_real_escape_string($link, $image),
        mysqli_real_escape_string($link, $text));
//  echo $query;
    $result = mysqli_query($link, $query);

    if (!$result)
        die(mysqli_error($link));

    return true;
}

function editArticle($link, $id, $category_id, $title, $image, $text)
{
// Подготовка
    $title = trim($title);//trim --  Удаляет пробелы из начала и конца строки
    $title_translit = translit($title);
    $text = trim($text);
    $image = trim($image);
//$pubdate = trim($pubdate);
    $id = (int)$id;
    $category_id = (int)$category_id;
// Проверка
    if ($title == '')
        return false;//не может быть статьи у которой заголовок пустой

// Запрос
    if ($image == null) {
        $templateUpdate = "UPDATE articles SET category_id='%d', title='%s', title_translit'%s', text='%s' WHERE id='%d'";
        $query = sprintf($templateUpdate,
            $category_id,
            mysqli_real_escape_string($link, $title),//проводит экранцию входящих параметров, добавляет обратный слэш, перед символями, которые могут испортить sql запрос
            mysqli_real_escape_string($link, $title_translit),
            mysqli_real_escape_string($link, $text),
//     mysqli_real_escape_string($link, $pubdate),
            $id);
    } else {
        $templateUpdate = "UPDATE articles SET category_id='%d', title='%s', title_translit'%s', image='%s', text='%s' WHERE id='%d'";
        $query = sprintf($templateUpdate,
            $category_id,
            mysqli_real_escape_string($link, $title),//проводит экранцию входящих параметров, добавляет обратный слэш, перед символями, которые могут испортить sql запрос
            mysqli_real_escape_string($link, $title_translit),
            mysqli_real_escape_string($link, $image),
            mysqli_real_escape_string($link, $text),
//     mysqli_real_escape_string($link, $pubdate),
            $id);
    }

    $result = mysqli_query($link, $query); //выполнение запроса

    if (!$result) //если нет результатов
        die(mysqli_error($link)); //приостановка работы и вывести ошибку

    return mysqli_affected_rows($link); //вовзращаем количество строк, которое отредактировали
}

function deleteArticle($link, $id)
{
    $id = (int)$id;
// Проверка
    if ($id == 0)//0 может в том случае, если не id не число
        return false;
// Запрос
    $deleteComments = sprintf("DELETE FROM comments WHERE articles_id='%d'", $id);
    $deleteArticle = sprintf("DELETE FROM articles WHERE id='%d'", $id);

    $result = mysqli_query($link, $deleteComments);
    $result2 = mysqli_query($link, $deleteArticle);

    if (!$result && !$result2)
        die(mysqli_error($link));

    return mysqli_affected_rows($link);
}


//точки по лимиту предложений
/*function articlesIntroSent($text, $sentencesLimit = 1)
{
$sentences = explode('.', $text, ($sentencesLimit + 1));
$sentencesInText = count(explode('.', $text));
if (count($sentences) > $sentencesLimit)
array_pop($sentences);
if ($sentencesInText > $sentencesLimit)
echo implode('.', $sentences) . '. ...';
else
echo implode('.', $sentences);
}*/

//точки по лимиту символов, с убиранием последнего слова
function introArticle($text, $size)
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

//точки по лимиту символов
//точки по лимиту слов
/*
function introArticle($text, $word_limit, $size)
{
    $textSize = mb_strlen($text);
    if ($textSize > $size) {
        $text = mb_substr($text, 0, $size);
        $words = explode(' ', $text, ($word_limit + 1));
        array_pop($words);
        echo implode(' ', $words) . '...';
    } else {
        $words = explode(' ', $text, ($word_limit + 1));
        $words_in_text = count(explode(' ', $text));
        if (count($words) > $word_limit)
            array_pop($words);
        if ($words_in_text > $word_limit) {
            echo implode(' ', $words) . '...';
        } else echo implode(' ', $words);
    }
}
*/

function getCategories($link)
{
    $categoriesQueryResult = mysqli_query($link, "SELECT * FROM articles_categories  ORDER BY id"); //цикл повторяется в header.php

    if (!$categoriesQueryResult)
        die(mysqli_error($link));
// Извлекаем данные
    $categories = array();
    while ($cat = mysqli_fetch_assoc($categoriesQueryResult)) {
        $categories[] = $cat;
    }
    return $categories;
}

function getCategory($link, $id)
{
    $query = "SELECT * FROM articles_categories WHERE id IN 
              (SELECT category_id FROM articles WHERE id =" . (int)$id . ")";
    $queryResult = mysqli_query($link, $query); //цикл повторяется в header.php
    if (!$queryResult)
        die(mysqli_error($link));
    $category = array();
    while ($cat = mysqli_fetch_assoc($queryResult)) {
        $category[] = $cat;
    }
    return $category;

}

function newCategory($link, $categoryNewName)
{
    if ($categoryNewName == '')
        return false;

// Запрос
    $categoryNewName = trim($categoryNewName);
    $translit = translit($categoryNewName);
    $query = "INSERT INTO articles_categories (title, title_translit)
              VALUES ('" . mysqli_real_escape_string($link, $categoryNewName) . "','". mysqli_real_escape_string($link, $translit) ."')";

    $result = mysqli_query($link, $query);

    if (!$result)
        die(mysqli_error($link));

    return true;
}


/////Удаление категории -->
function deleteCategory($link, $categoryID)
{

    $categoryID = (int)$categoryID;


// Проверка
    if ($categoryID == 0)//0 может в том случае, если не id не число
        return false;

    $imagesID = "SELECT id FROM articles WHERE category_id=" . $categoryID;
    $result = mysqli_query($link, $imagesID);
    while ($Image = mysqli_fetch_assoc($result)) {
        $Image = (int)$Image['id'];
        deleteImage($link, $Image);
    }

    /*   $queryWhereIsArticles = "SELECT image FROM articles WHERE category_id=" . $categoryID;
    $result = mysqli_query($link, $queryWhereIsArticles);


    while ($deletePhoto = mysqli_fetch_assoc($result)) {
    if ($deletePhoto['image'] != null) {
    $imageDeletePath = '../static/images/' . $deletePhoto['image'];
    $imagePreviewDeletePath = '../static/imagesPreview/' . $deletePhoto['image'];
    unlink($imageDeletePath);
    unlink($imagePreviewDeletePath);
    }
    }
    */


// Запрос
    $deleteComments = sprintf("DELETE FROM comments WHERE articles_id IN 
                              (SELECT id FROM articles WHERE category_id='" . $categoryID . "')");
    $deleteCategoryInArticles = sprintf("DELETE FROM articles WHERE category_id='%d';", $categoryID);
    $deleteArticles = sprintf("DELETE FROM articles_categories WHERE id='%d';", $categoryID);

    $result = mysqli_query($link, $deleteComments);
    $result2 = mysqli_query($link, $deleteCategoryInArticles);
    $result3 = mysqli_query($link, $deleteArticles);

    if (!$result && !$result2 && !$result3)
        die(mysqli_error($link));

    return mysqli_affected_rows($link);
}

function getComments($link, $articleID)
{
    $articleID = (int)$articleID;
    if ($articleID == 0)//0 может в том случае, если не id не число
        return false;

    $query = "SELECT * FROM comments WHERE articles_id = " . (int)$articleID . " ORDER BY id DESC";
    $result = mysqli_query($link, $query);
    if (!$result)
        die(mysqli_error($link));
    $comments = array();
    while ($comment = mysqli_fetch_assoc($result)) {
        $comments[] = $comment;
    }

    return $comments;
}

function deleteComment($link, $id, $articleID)
{

    $id = (int)$id;

// Проверка
    if ($id == 0)//0 может в том случае, если не id не число
        return false;

// Запрос
    $query = sprintf("DELETE FROM comments WHERE id='" . $id . "'");

    $result = mysqli_query($link, $query);
    if (!$result)
        die(mysqli_error($link));

    return mysqli_affected_rows($link);

}

function uploadImage()
{
// Пути загрузки файлов
    $path = '../public/static/images/';
    $pathResize = '../public/static/imagesPreview/';
    $tmpPath = '';
    $tmpPathPreview = '../';
// Массив допустимых значений типа файла
    $types = array("image/png", "image/jpeg");
// Максимальный размер файла
    $size = 5024000;
// Обработка запроса
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
// Проверяем тип файла
        if (!in_array($_FILES['image']['type'], $types))
            die('Запрещённый тип файла. <a href="javascript:history.back()">Попробовать другой файл?</a>');
// Проверяем размер файла
        if ($_FILES['image']['size'] > $size)
            die('Слишком большой размер файла. <a href="javascript:history.back()">Попробовать другой файл?</a>');
    }
    $name = resize($_FILES['image'], $type = 2, $tmpPath);
    $namePreview = resize($_FILES['image'], $type = 1, $tmpPathPreview);

    copy($tmpPath . $name, $path . $name);
    copy($tmpPathPreview . $namePreview, $pathResize . $namePreview);

    unlink($tmpPath . $name);
    unlink($tmpPathPreview . $namePreview);
}

function changeImageName($link, $articleID, $image)
{
    $articleID = (int)$articleID;
    $templateUpdate = "UPDATE articles SET image='%s' WHERE id='%d'";
    $queryUpd = sprintf($templateUpdate,
        mysqli_real_escape_string($link, $image),
        $articleID);
    $result = mysqli_query($link, $queryUpd);
    if (!$result) {//если нет результатов
        die(mysqli_error($link)); //приостановка работы и вывести ошибку
    }
    return mysqli_affected_rows($link);
}

function deleteImage($link, $articleID)
{
    $articleID = (int)$articleID;

    $article = getArticle($link, $articleID);
    $templateSelect = "SELECT COUNT(image) AS repeats FROM articles WHERE image='%s'";
    $querySel = sprintf($templateSelect,
        mysqli_real_escape_string($link, $article['image']));
    $totalCountQuery = mysqli_query($link, $querySel);
    $totalCount = mysqli_fetch_assoc($totalCountQuery);
    $templateUpdate = "UPDATE articles SET image='default.jpg' WHERE id=" . $articleID;
    $queryUpd = mysqli_query($link, $templateUpdate);
    if (!$totalCountQuery && !$queryUpd) {//если нет результатов
        die(mysqli_error($link)); //приостановка работы и вывести ошибку
    }
    if ($totalCount['repeats'] == 1) { //проверка на повторы
        $imageDeletePath = '../public//static/images/' . $article['image'];
        $imagePreviewDeletePath = '../public/static/imagesPreview/' . $article['image'];
        if ($article['image'] != null && $article['image'] != 'default.jpg') { //проверка на наличие фотографии в целом
            unlink($imageDeletePath);
            unlink($imagePreviewDeletePath);
        }
    }

    return mysqli_affected_rows($link); //вовзращаем количество строк, которое отредактировали
}

function resize($file, $type, $directory, $rotate = null, $quality = null)
{
// Функция изменения размера
// Изменяет размер изображения в зависимости от type:
//    type = 1 - эскиз
//    type = 2 - большое изображение
//    rotate - поворот на количество градусов (желательно использовать значение 90, 180, 270)
//    quality - качество изображения (по умолчанию 75%)

    $tmpPath = $directory;


// Ограничение по ширине в пикселях
    $maxThumbSize = 150;
    $maxSize = 600;

// Качество изображения по умолчанию
    if ($quality == null)
        $quality = 100;

// Cоздаём исходное изображение на основе исходного файла
    if ($file['type'] == 'image/jpeg')
        $source = imagecreatefromjpeg($file['tmp_name']);
    else if ($file['type'] == 'image/png')
        $source = imagecreatefrompng($file['tmp_name']);
    else
        return false;

// Поворачиваем изображение
    if ($rotate != null)
        $src = imagerotate($source, $rotate, 0);
    else
        $src = $source;

// Определяем ширину и высоту изображения
    $wSrc = imagesx($src);
    $hSrc = imagesy($src);

// В зависимости от типа (эскиз или большое изображение) устанавливаем ограничение по ширине.
    if ($type == 1)
        $w = $maxThumbSize;
    else if ($type == 2)
        $w = $maxSize;

// Если ширина больше заданной
    if ($wSrc > $w) {
// Вычисление пропорций
        $ratio = $wSrc / $w;
        $wDest = round($wSrc / $ratio);
        $hDest = round($hSrc / $ratio);

// Создаём пустую картинку
        $dest = imagecreatetruecolor($wDest, $hDest);

// Копируем старое изображение в новое с изменением параметров
        imagecopyresampled($dest, $src, 0, 0, 0, 0, $wDest, $hDest, $wSrc, $hSrc);

// Вывод картинки и очистка памяти
        if ($file['type'] == 'image/jpeg')
            imagejpeg($dest, $tmpPath . $file['name'], $quality);
        else if ($file['type'] == 'image/png') {
            $q = 9 / 100;
            $quality *= $q;
            imagepng($dest, $tmpPath . $file['name'], $quality);
        } else
            return false;
        imagedestroy($dest);
        imagedestroy($src);
        return $file['name'];
    } else {
// Вывод картинки и очистка памяти
        if ($file['type'] == 'image/jpeg')
            imagejpeg($src, $tmpPath . $file['name'], $quality);
        else if ($file['type'] == 'image/png') {
            $q = 9 / 100;
            $quality *= $q;
            imagepng($src, $tmpPath . $file['name'], $quality);
        } else
            return false;
        imagedestroy($src);

        return $file['name'];
    }
}

function searchArticles($link, $keyWord)
{
    $keyWord = trim($keyWord);
    $keyWord = mysqli_real_escape_string($link, $keyWord);
    $keyWord = htmlspecialchars($keyWord);

    if (!empty($keyWord)) {
        if (mb_strlen($keyWord) < 3) {
            $matchFound = '<p>Слишком короткий поисковый запрос.</p>';
        } else if (strlen($keyWord) > 128) {
            $matchFound = '<p>Слишком длинный поисковый запрос.</p>';
        } else {
            $q = "SELECT *
FROM articles WHERE title LIKE '%$keyWord%'
OR text LIKE '%$keyWord%'";

            $result = mysqli_query($link, $q);

            if (mysqli_affected_rows($link) > 0) {


                $matchFound = array();
                while ($foundStr = mysqli_fetch_assoc($result)) {
                    $matchFound[] = $foundStr;
                }
                return $matchFound;
            } else {
                $matchFound = '<p>По вашему запросу ниодной статьи не найдено.</p>';
            }
        }
    } else {
        $matchFound = '<p>Задан пустой поисковый запрос.</p>';
    }
    return $matchFound;
}

function checkUser($link, $email, $password)
{
    $email = trim($email);
    $password = trim($password);

    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($link, $query);
    if ($is = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $is['password']))
            return true;
    } else return false;
}

function isAdmin($link, $email)
{

    $email = trim($email);
    $q = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($link, $q);
    $isOrNot = mysqli_fetch_assoc($result);
    return $isOrNot["admin"];

}

function redirect($link)
{
    $link = "Location: " . $link;
    header($link);
}

function pagination($page, $totalPages)
{
    if ($page > 1) {
        echo '<a href="/admin/index.php?page=' . ($page - 1) . '">
                <div class="paginationLeft">&laquo;' . ($page - 1) . ' страница</div></a>';
    }
    if ($page < $totalPages) {
        echo '<a href="/admin/index.php?page=' . ($page + 1) . '">
                <div class="paginationRight">' . ($page + 1) . '  страница &raquo;</div></a>';
    }
}

function translit($title)
{
    //  $title = preg_replace('~[^-a-z0-9_]+~u', '-', $title);
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
