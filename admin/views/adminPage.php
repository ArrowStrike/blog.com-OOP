<?php
require_once "/models/start.php";
?>
<!DOCTYPE html>
<hmtl>
    <?php
    require "links.php";
    ?>
    <body>
    <div class="container">
        <!-- Header (navbar) -->
        <header id="header">
            <nav class="navbar navbar-default">
                <div class="header__top" style="padding:0;">
                    <div class="container">
                        <nav class="header__top__menu">
                            <ul>
                                <li><a href="/admin/index.php?action=add">
                                        <z><b>Добавить статью</b></z>
                                    </a>
                                <li><a href="/">Перейти на сайт</a>
                                <li><a href="/admin/models/logout.php">Выход</a>
                            </ul>

                        </nav>
                    </div>
                </div>
            </nav>
            <div id="addart">
                <form method="post" action="/admin/index.php?action=addCategory">
                    <!-- Добавление категории -->
                    <label>
                        Добавить категорию
                        <input type="text" name="newNameOfCategory" value="" class="form-item" placeholder="Название"
                               required title="Введите название категории">
                    </label>
                    <input type="submit" value="Добавить" class="btn" name="getPost">
                </form>
                <br>
                <form method="post" action="/admin/index.php?action=deleteCategory">
                    <label>
                        Удалить категорию. <br>
                        <z>ВНИМАНИЕ! Удаление категории приведет к удалению всех привязанных к ней статей, фотографий и
                            комментариев.<br>
                            Перед удалением, поменяйте категорию у статей, которые хотите сохранить!
                        </z>
                        <br>
                        <select required name="category_id" autofocus title="Выберите категорию">
                            <option disabled selected></option><?php
                            foreach ($categories as $cat) {
                                ?>
                                <option value="<?php echo $cat['id']; ?>"><?php echo $cat['title']; ?> (id=<?php echo $cat['id']; ?>)</option>
                            <?php } ?>
                        </select>
                    </label>
                    <input type="submit" id="show" value="Удалить" class="btn" name="doPost">
                </form>
            </div>
            <br>
            <form method="post">
                <!-- ПОИСК СТАТЬИ -->
                <label>
                    Поиск статьи по отрывку или названию
                    <input type="text" name="searchArticle" value="" class="form-item" placeholder="Поиск"
                           required>
                </label>
                <input type="submit" value="Найти" class="btn">
            </form>
            <?php if (isset($_POST['searchArticle'])) {
                if (is_array($matchFound)) {
                    echo '<p>По запросу "<b>' . $_POST['searchArticle'] .
                        '</b>"  найдено совпадений: ' . count($matchFound) . '</p>';
                    ?>
                    <table class="table">
                        <tr>
                            <th><b>Дата и время публикации</b></th>
                            <th><b>Категория</b></th>
                            <th><b>Заголовок</b></th>
                            <th><b>Редактирование/Удаление комментариев</b></th>
                            <th><b>Удаление</b></th>
                        </tr>
                        <?php foreach ($matchFound as $elem): ?>
                            <tr>
                                <td><?= $elem['pubdate'] ?></td>
                                <td>id=<?= $elem['category_id'] ?></td>
                                <td><?= introArticle($elem['title'], 50); ?></td>
                                <td>
                                    <a href="/admin/index.php?action=edit&id=<?= $elem['id'] ?>">Редактировать</a>
                                </td>
                                <td>
                                    <a href="/admin/index.php?action=delete&id=<?= $elem['id'] ?>"
                                       title="ВНИМАНИЕ! Удаление статьи приведет к удалению всех привязанных к ней комментариев! ">
                                        Удалить
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </table><br>
                <?php } else echo $matchFound;
            } ?>

            <!-- END Header (navbar) -->
            <br>
            <?php if (!empty($articles[0]['id'])) { ?>
                <table class="table">
                    <label> Все статьи
                        <tr>
                            <th><b>Дата и время публикации</b></th>
                            <th><b>Категория</b></th>
                            <th><b>Заголовок</b></th>
                            <th><b>Редактирование/Удаление комментариев</b></th>
                            <th><b>Удаление</b></th>
                        </tr>
                        <?php
                        foreach ($articles as $article): ?>
                            <tr>
                                <td><?= $article['pubdate'] ?></td>
                                <td>id=<?= $article['category_id'] ?></td>
                                <td><?= introArticle($article['title'], 50) ?></td>
                                <td>
                                    <a href="/admin/index.php?action=edit&id=<?= $article['id'] ?>">
                                        Редактировать
                                    </a>
                                </td>
                                <td>
                                    <a href="/admin/index.php?action=delete&id=<?= $article['id'] ?>&page=<?= $articles[0]['page'] ?>"
                                       title="ВНИМАНИЕ! Удаление статьи приведет к удалению всех привязанных к ней комментариев! ">
                                        Удалить
                                    </a>
                                </td>
                            </tr>
                            <?php
                        endforeach;


                        ?>
                    </label>
                </table>

            <?php } else echo "В данный момент нет ниодной статьи";
            pagination($articles[0]['page'], $articles[0]['totalPages']);
            ?>


    </div>
    <footer>
        <p>
            Блог Влада<br>Copyright &copy; 2017
        </p>
    </footer>
    </body>
</hmtl>

