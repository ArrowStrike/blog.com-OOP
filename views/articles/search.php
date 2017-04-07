<div class="block">
    <h3>Результат поиска</h3><br>
    <?php

    $page = 1;
    $countOfArticlesPerPage = 4;//количество записей на стринце
    //текущая страница
    if (isset($_GET['search'])) {

        if (isset($_GET['p'])) {
            $page = (int)$_GET['p'];
        }

        $keyWord = $_GET['search'];
        $offset = ($countOfArticlesPerPage * $page) - $countOfArticlesPerPage; //сдвиг
        $keyWord = trim($keyWord);
        $keyWord = mysqli_real_escape_string($connection, $keyWord);
        $keyWord = htmlspecialchars($keyWord);
        $totalCount = 0;//количество записей(статей)

        if (!empty($keyWord)) {
            if (mb_strlen($keyWord) < 3) {
                $matchFound = '<p>Слишком короткий поисковый запрос.</p>';
            } else if (strlen($keyWord) > 128) {
                $matchFound = '<p>Слишком длинный поисковый запрос.</p>';
            } else {
                $q = "SELECT *
                  FROM articles WHERE title LIKE '%$keyWord%'
                  OR text LIKE '%$keyWord%' LIMIT $offset,$countOfArticlesPerPage";
                $result = mysqli_query($connection, $q);
                if (mysqli_affected_rows($connection) > 0) {

                    $matchFound = array();
                    while ($foundStr = mysqli_fetch_assoc($result)) {
                        $matchFound[] = $foundStr;
                    }
                } else {
                    $matchFound = '<p>По запросу "' . $keyWord . '" ниодной статьи не найдено.</p>';
                }
                $totalCountArticles = mysqli_query($connection,
                    "SELECT COUNT(id) AS total_count 
                    FROM articles WHERE title LIKE '%$keyWord%'
                    OR text LIKE '%$keyWord%'");
                $totalCount = mysqli_fetch_assoc($totalCountArticles);
                $totalCount = $totalCount['total_count'];
            }
        } else {
            $matchFound = '<p>Задан пустой поисковый запрос.</p>';
        }
    }


    if (is_array($matchFound)) {
        echo '<p>По запросу "<b>' . $keyWord . '</b>"  найдено совпадений: ' . $totalCount . '</p>';
    } else echo $matchFound; ?>

    <div class="block__content">
        <div class="articles articles__horizontal">
            <?php
            foreach ($matchFound as $match) {
                ?>
                <article class="article">
                    <a href="/article/<?php echo $match['id'] . "-" . translit($match['title']); ?>">
                        <div class="article__image"
                             style="background-image: url(/public/static/imagesPreview/<?php echo $match['image']; ?>);">
                        </div>
                    </a>
                    <div class="article__info">
                        <a href="/article/<?php echo $match['id'] . "-" . translit($match['title']); ?>">
                            <?php introArticle($match['title'], 50) ?>
                        </a>
                        <div class="article__info__meta">
                            <?php
                            $art_cat = false;
                            foreach ($categories as $cat) {
                                if ($cat['id'] == $match['category_id']) {
                                    $art_cat = $cat;
                                    break;
                                }
                            }
                            ?>
                            <small>Категория:
                                <a href="/<?php echo $art_cat['id'] . "-" . translit($art_cat['title']);; ?>">
                                    <?php echo $art_cat['title']; ?>
                                </a>
                            </small>
                        </div>
                        <div
                            class="article__info__preview"><?php introArticle($match['text'], 100); ?>
                        </div>
                    </div>
                </article>
                <?php
            }
            ?>
        </div>

        <?php


        $totalPages = ceil($totalCount / $countOfArticlesPerPage);
        if ($page <= 1 || $page > $totalPages) {
            $page = 1;
        }

        if ($page > 1) {
            echo '<a href="/articles?search=' . $keyWord . '&p=' . ($page - 1) . '">
            <div class="paginationLeft">&laquo;' . ($page - 1) . ' страница</div></a>';
        }
        if ($page < $totalPages) {
            echo '<a href="/articles?search=' . $keyWord . '&p=' . ($page + 1) . '">
            <div class="paginationRight">' . ($page + 1) . ' страница &raquo;</div></a>';
        }
        ?>

    </div>
</div>
