<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> <?php echo Configs::getConfig('title') ?></title>

    <?php
    include ROOT . "/views/layouts/links.php";
    ?>

</head>
<body>

<div id="wrapper">

    <?php include ROOT . "/views/layouts//header.php"; ?>

    <div id="content">
        <div class="container">
            <div class="row">
                <section class="content__left col-md-8">
                    <?php
                    if (isset($_GET['search'])) {
                        include ROOT . "/views/articles/search.php";
                    }
                    else {
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

    <? include ROOT . "/views/layouts/footer.php";
    ?>
</div>

</body>
</html>