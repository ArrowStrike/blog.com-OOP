<?php
//-------FRONT CONTROLLER-------

require_once("models/database.php");
require_once("models/functions.php");

$link = db_connect();
$version = 1;
//$article['title'] = '';
//$article['text'] = '';


if (isset($_POST['searchArticle'])&&!empty($_POST)) {
        $matchFound = searchArticles($link, $_POST['searchArticle']);
}

$action = "";
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}
if ($action != null) {
    if ($action == 'add') {
        if ($_FILES['image']['name'] != null) {
            uploadImage();
        } else {
            $_FILES['image']['name'] = 'default.jpg';
        }

        if (!empty($_POST)) {
            newArticle($link, (int)$_POST['category_id'], $_POST['title'], $_FILES['image']['name'], $_POST['text']);
            redirect("index.php");
        }
        $categories = getCategories($link);
        include("views/addEditPage.php");
    }
    if ($action == 'edit') {//входящий параметр action = edit

        if (!isset($_GET['id'])) {//если не установлен параметр id, не знаем, какую открывать статью для редактирования
            redirect("index.php");
        }//переправляем на клавную страницу администратора
        $articleID = (int)$_GET['id'];//если параметр задан, то конвертируем его в тип int
        $categories = getCategories($link);
        $category = getCategory($link, $articleID);
        $comments = getComments($link, $articleID);
        //если постданные пустые
        if (!empty($_POST) && $articleID > 0) {//введенные параметры не должны быть пустыми//$_POST введенные данные
            if ($_FILES['image']['name'] != null) {
                deleteImage($link, $articleID);
                uploadImage();
            }
            editArticle($link, $articleID, (int)$_POST['category_id'], $_POST['title'],
                        $_FILES['image']['name'], $_POST['text']);
            redirect("index.php");//переадрессация на главную страницу
        }
        $article = getArticle($link, $articleID);
        include("views/addEditPage.php");  //отображаем данные для редактирования
    }
    if ($action == 'delete') {
        $articleID = (int)$_GET['id'];
        $isImage = getArticle($link, $articleID);
        if ($isImage['image'] != null) {
            deleteImage($link, $articleID);
        }
        $article = deleteArticle($link, $articleID);
        if (isset($_GET['page'])) {
            redirect('index.php?page=' . $_GET['page']);
        } else {
            redirect("index.php");//переадресация на главную страницу
        }
    }
    if ($action == 'deleteImage') {
        $articleID = (int)$_GET['id'];
        $isImage = getArticle($link, $articleID);
        if ($isImage['image'] != null) {
            deleteImage($link, $articleID);
        }
        redirect('index.php?action=edit&id=' . $articleID);
    }
    if ($action == 'changeImage') {
        $articleID = (int)$_GET['id'];
        $isImage = getArticle($link, $articleID);
        if ($_FILES['image']['name'] != null) {
            deleteImage($link, $articleID);
            uploadImage();
            changeImageName($link, $articleID, $_FILES['image']['name']);
        }
        redirect('index.php?action=edit&id=' . $articleID);
    }
    if ($action == 'deleteCategory') {
        $categories = deleteCategory($link, (int)$_POST['category_id']);
        redirect("index.php");
    }
    if ($action == 'addCategory') {
        if (!empty($_POST)) {
            newCategory($link, $_POST['newNameOfCategory']);
        }
        redirect("index.php");//переадресация на главную страницу
    }
    if ($action == 'deleteComment') {
        $id = (int)$_GET['id'];
        $articleID = (int)$_GET['articleID'];
        $comments = deleteComment($link, $id, $articleID);
        redirect("index.php?action=edit&id=" . $articleID);
    }
} else {
    $categories = getCategories($link);
    $articles = allArticles($link);
    include("views/adminPage.php");
}
