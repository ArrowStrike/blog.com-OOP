<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo Configs::getConfig('title') ?></title>

    <?php
    require ROOT . "/views/layouts/links.php";
    ?>

</head>
<body>

<div id="wrapper">

    <?php include ROOT . "/views/layouts/header.php"; ?>
    <div id="content">
        <div class="container">
            <div class="row">
                <section class="content__left col-md-8">
                    <div class="block">
                        <a href="articles">Все записи</a>
                        <h3>Свежее</h3>

                        <?php
                        include ROOT . "/views/site/bodyRecentArticles.php"; ?>

                    </div>
                    <div class="block">
                        <a href="/kulinariya">Все записи</a>
                        <h3>Life Style [Новейшее]</h3>

                        <?php

                        $articleList = Articles::getArticleList('kulinariya');
                        include ROOT . "/views/site/bodyRecentArticles.php"; ?>

                    </div>
                    <div class="block">
                        <a href="/sadovodstvo">Все записи</a>
                        <h3>IT [Новейшее]</h3>

                        <?php
                        $articleList = Articles::getArticleList('sadovodstvo');
                        include ROOT . "/views/site/bodyRecentArticles.php"; ?>

                    </div>
                </section>
                <section class="content__right col-md-4">

                    <?php include ROOT . "/views/layouts/sidebar.php"; ?>

                </section>
            </div>
        </div>
    </div>

    <? include ROOT . "/views/layouts/footer.php";
    ?>
</div>

</body>
</html>