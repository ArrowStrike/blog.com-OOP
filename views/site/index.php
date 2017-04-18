<?php include ROOT . "/views/layouts/htmlSet.php"; ?>
    <title><?php echo Config::getConfig('title') ?></title>

<?php
include ROOT . "/views/layouts/links.php";
include ROOT . "/views/layouts/header.php"; ?>

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
                        <a href="/life-style">Все записи</a>
                        <h3>Life Style [Новейшее]</h3>

                        <?php
                        $articleList = Articles::getArticleList(Config::getConfig('articlePerPage'), 'life-style');
                        include ROOT . "/views/site/bodyRecentArticles.php"; ?>

                    </div>
                    <div class="block">
                        <a href="/it">Все записи</a>
                        <h3>IT [Новейшее]</h3>

                        <?php
                        $articleList = Articles::getArticleList(Config::getConfig('articlePerPage'), 'it');
                        include ROOT . "/views/site/bodyRecentArticles.php"; ?>

                    </div>
                </section>
                <section class="content__right col-md-4">

                    <?php include ROOT . "/views/layouts/sidebar.php"; ?>

                </section>
            </div>
        </div>
    </div>

<?php include ROOT . "/views/layouts/footer.php"; ?>