<?php include ROOT . "/views/layouts/htmlSet.php"; ?>
    <title> <?php echo Config::getConfig('title') ?></title>
<?php
include ROOT . "/views/layouts/links.php";
include ROOT . "/views/layouts/header.php"; ?>

    <div id="content">
        <div class="container">
            <div class="row">
                <section class="content__left col-md-8">
                    <?php
                    if (!$articleList) {
                        ?>
                        <div class="block">
                            <h3>Статьи не найдены!</h3><br>
                            <p>Извините, в данной категории отсутсвуют статьи</p
                        </div>
                        <?php
                    } else {
                        include ROOT . "/views/articles/bodyAllArticles.php";
                    }
                    ?>
                </section>
                <section class="content__right col-md-4">

                    <?php include ROOT . "/views/layouts/sidebar.php"; ?>

                </section>
            </div>
        </div>
    </div>
<? include ROOT . "/views/layouts/footer.php"; ?>