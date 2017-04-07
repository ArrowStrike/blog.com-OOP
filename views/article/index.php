<?php
require "../includes/config.php";

$article = mysqli_query($connection, "SELECT * FROM articles WHERE id = " . (int)$_GET['id']);
$art = mysqli_fetch_assoc($article);
if (($_SERVER['REQUEST_URI']) != "/article/" . $art['id'] . "-" . translit($art['title']) && mysqli_num_rows($article) != 0) {
    redirect("/article/" . $art['id'] . "-" . translit($art['title']));
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Article</title>
    <?php
    require "../includes/links.php";
    ?>
</head>
<body>

<div id="wrapper">

    <?php include "../includes/header.php"; ?>

    <?php
    if (mysqli_num_rows($article) <= 0) {
        ?>
        <div id="content">
            <div class="container">
                <div class="row">
                    <section class="content__left col-md-8">
                        <div class="block">
                            <h3>Статья не найдена!</h3>
                            <div class="block__content">
                                <div class="full-text">
                                    Запрашиваемая Вами статья не существует
                                </div>
                            </div>
                        </div>
                    </section>
                    <section class="content__right col-md-4">
                        <?php include "../includes/sidebar.php"; ?>
                    </section>
                </div>
            </div>
        </div>
        <?php
    } else {

        mysqli_query($connection, "UPDATE articles SET views = views + 1 WHERE id = " . (int)$art['id']);
        ?>
        <div id="content">
            <div class="container">
                <div class="row">
                    <section class="content__left col-md-8">
                        <div class="block">
                            <a>Просмотров: <?php echo $art['views']; ?> </a>

                            <h3><?php echo $art['title']; ?></h3>
                            <div class="block__content">
                                <?php if ($art['image'] != null && $art['image'] != 'default.jpg') { ?>
                                    <div class="images"><img src="/static/images/<?php echo $art['image']; ?>"
                                                             style="max-width: 100%"></div><?php } ?>
                                <div class="full-text">
                                    <?php echo $art['text']; ?>
                                </div>
                            </div>
                            <br>
                            <a>Опубликовано: <?php echo date('d-m-y H:i', strtotime($art['pubdate'])); ?> </a>
                        </div>
                        <?php include "../includes/viewComments.php";
                        include "../includes/addComments.php"; ?>
                    </section>
                    <section class="content__right col-md-4">
                        <?php include "../includes/sidebar.php"; ?>
                    </section>
                </div>
            </div>
        </div>
        <?php

    }
    ?>

    <?php include "../includes/footer.php"; ?>

</div>

</body>
</html>