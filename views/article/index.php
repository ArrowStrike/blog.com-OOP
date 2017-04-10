<?php include ROOT . "/views/layouts/htmlSet.php"; ?>
    <title><?php echo $articleItem['title']; ?></title>
<?php
include ROOT . "/views/layouts/links.php";
include ROOT . "/views/layouts/header.php";
if ($articleItem == false) {
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
                    <?php include ROOT . "/views/layouts/sidebar.php"; ?>
                </section>
            </div>
        </div>
    </div>
    <?php
} else {
    ?>
    <div id="content">
        <div class="container">
            <div class="row">
                <section class="content__left col-md-8">
                    <div class="block">
                        <a>Просмотров: <?php echo $articleItem['views']; ?> </a>

                        <h3><?php echo $articleItem['title']; ?></h3>
                        <div class="block__content">
                            <?php if ($articleItem['image'] != null && $articleItem['image'] != 'default.jpg') { ?>
                                <div class="images">
                                <img src="../public/static/images/<?php echo $articleItem['image']; ?>"
                                     style="max-width: 75%"></div><?php } ?>
                            <div class="full-text">
                                <?php echo $articleItem['text']; ?>
                            </div>
                        </div>
                        <br>
                        <a>Опубликовано: <?php echo date('d-m-y H:i', strtotime($articleItem['pubdate'])); ?> </a>
                    </div>
                    <?php include ROOT . "/views/article/viewComments.php";
                    include ROOT . "/views/article/addComments.php"; ?>
                </section>
                <section class="content__right col-md-4">
                    <?php include ROOT . "/views/layouts/sidebar.php"; ?>
                </section>
            </div>
        </div>
    </div>
    <?php
}
?>

<?php include ROOT . "/views/layouts/footer.php"; ?>