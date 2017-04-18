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
        $commentsList = array();
        $result = $GLOBALS['DB']->query("SELECT * FROM comments ORDER BY id DESC LIMIT 5");
        $result->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $result->fetch()) {
            $commentsList[] = $row;
        }

        return $commentsList;
    }

    public static function getComments($id)
    {
           $id = (int)$id;

        $result = $GLOBALS['DB']->query("SELECT * FROM comments 
                                      WHERE articles_id = " . $id . " ORDER BY id DESC");

        $result->setFetchMode(PDO::FETCH_ASSOC);

        $commentsList = array();

        while ($row = $result->fetch()) {
            $commentsList[] = $row;
        }

        return $commentsList;
    }

    public static function commentsValidator($articleID)
    {
        // Поля для формы

        // Статус успешного загрузки комментария
        $logs = false;

        // Обработка формы
        if (isset($_POST['submit'])) {

            // Если форма отправлена
            // Получаем данные из формы
            $logs['commentUserName'] = $_POST['name'];
            $logs['commentUserEmail'] = $_POST['email'];
            $logs['commentText'] = $_POST['text'];


            // Валидация полей
            if (!empty($name)) {
                $logs['errors'][] = 'Введите имя!';
            }
            if (!Comments::checkEmail($logs['commentUserEmail'])) {
                $logs['errors'][] = 'Введите правильный Email!';
            }
            if (!empty($text)) {
                $logs['errors'][] = 'Введите текст комментария!';
            }

            if (!isset($logs['errors'])) {
                // Если ошибок нет
                // Сохраняем комментарий в базе данных
                $logs['result'] = Comments::addComments($logs['commentUserName'],
                    $logs['commentUserEmail'],
                    $logs['commentText'],
                    $articleID);

                if ($logs['result']) {

                    $logs['message'] = 'Комментарий успешно добавлен!';
                    $logs['commentUserName'] = false;
                    $logs['commentUserEmail'] = false;
                    $logs['commentText'] = false;
                    Comments::clearComments();
                }
            }
        }
        return $logs;
    }

    public static function checkEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false || empty($email)) {
            return false;
        }
        return true;
    }

    public static function addComments($commentUserName, $commentUserEmail, $commentText, $articleID)
    {
        $sql = 'INSERT INTO comments (author, email, text, pubdate, articles_id) '
            . 'VALUES (:author, :email, :text, NOW(), :articles_id)';

        $result = $GLOBALS['DB']->prepare($sql);
        $result->bindParam(':author', $commentUserName, PDO::PARAM_STR);
        $result->bindParam(':email', $commentUserEmail, PDO::PARAM_STR);
        $result->bindParam(':text', $commentText, PDO::PARAM_STR);
        $result->bindParam(':articles_id', $articleID, PDO::PARAM_INT);

        return $result->execute();
    }

    public static function clearComments()
    {
        if (isset($_POST)) {
            unset($_POST);
        }
    }


    public static function setResultOfValidation($logs)
    {

        if (isset($logs['result'])) {
            echo '<span style="color: green; font-weight:bold; margin-bottom: 10px; display: block; " >
                        Комментарий успешно добавлен!
                      </span>';
        }
        if (!isset($logs['result'])) {
            if (isset($logs['errors']) && is_array($logs['errors'])) {
                echo '<span style="color: red; font-weight:bold; margin-bottom: 10px; display: block; "> '
                    . $logs['errors'][0] .
                    '</span>';
            }
        }

    }
}
