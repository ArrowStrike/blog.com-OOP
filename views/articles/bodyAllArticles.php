<div class="block">
    <?php
/*
    $countOfArticlesPerPage = 6;//количество записей на стринце
    $page = 1; //текущая страница
    if (isset($_GET['page'])) {
        $page = (int)$_GET['page'];
    }
    $categoryInclude = false;
    $totalCountQuery = mysqli_query($connection, "SELECT COUNT(id) AS total_count FROM articles");
    if (isset($_GET['category'])) {
        $totalCountQuery = mysqli_query($connection, "SELECT COUNT(category_id) AS total_count 
                                                      FROM articles WHERE category_id=" . (int)$_GET['category']);
        $categoryInclude = true;
    }

    $totalCount = mysqli_fetch_assoc($totalCountQuery);
    $totalCount = $totalCount['total_count'];//количество записей(статей)

    $totalPages = ceil($totalCount / $countOfArticlesPerPage);
    if ($page <= 1 || $page > $totalPages) {
        $page = 1;
    }

    $offset = ($countOfArticlesPerPage * $page) - $countOfArticlesPerPage; //сдвиг
    $articles = mysqli_query($connection, "SELECT * FROM articles ORDER BY id DESC LIMIT $offset,$countOfArticlesPerPage");
    if (isset($_GET['category'])) {
        $query = "SELECT * FROM articles WHERE category_id=" . (int)$_GET['category'] .
            " ORDER BY id DESC LIMIT $offset,$countOfArticlesPerPage";
        $articles = mysqli_query($connection, $query);
    }
    $articlesExist = true;

    if (mysqli_num_rows($articles) <= 0) {
        echo "<h3>Извините, в данной категории отсутсвуют статьи</h3>";
        $articlesExist = false;
    } else echo "<h3>Все статьи</h3>"; */?>

    <div class="block__content">
        <div class="articles articles__horizontal">
            <?php
             foreach ($articleList as $article) {
                ?>
                 <article class="article">
                     <a href="/article/<?php echo $article['title_translit']; ?>">
                         <div class="article__image"
                              style="background-image: url(/public/static/imagesPreview/<?php echo $article['image']; ?>);">
                         </div>
                     </a>
                     <div class="article__info">
                         <a href="/article/<?php echo $article['title_translit']; ?>">
                             <?php Functions::introArticle($article['title'], 50);
                             $art_cat=Functions::compareCategory($categories, $article['category_id'] );?>
                         </a>
                         <div class="article__info__meta">
                             <small>Категория:
                                 <a href="/<?php echo $art_cat['title_translit']; ?>">
                                     <?php echo $art_cat['title']; ?>
                                 </a>
                             </small>
                         </div>
                         <div
                             class="article__info__preview"><?php Functions::introArticle($article['text'], 70); ?>
                         </div>
                     </div>
                 </article>
                <?php
            }
            ?>
        </div>

        <?php/*
        if ($articlesExist == true && $categoryInclude != true) {
            if ($page > 1) {
                echo '<a href="/articles/' . ($page - 1) . '">
                <div class="paginationLeft">&laquo;' . ($page - 1) . ' страница</div></a>';
            }
            if ($page < $totalPages) {
                echo '<a href="/articles/' . ($page + 1) . '">
                <div class="paginationRight">' . ($page + 1) . ' страница &raquo;</div></a>';
            }
        }
        if ($articlesExist == true && $categoryInclude == true) {
            if ($page > 1) {
                echo '<a href="/' . (int)$_GET['category'] . "-" .
                    translit($art_cat['title']) . '/' . ($page - 1) . '">
                    <div class="paginationLeft">&laquo;' . ($page - 1) . ' страница</div></a>';
            }
            if ($page < $totalPages) {
                echo '<a href="/' . (int)$_GET['category'] . "-" .
                    translit($art_cat['title']) . '/' . ($page + 1) . '">
                    <div class="paginationRight">' . ($page + 1) . ' страница &raquo;</div></a>';
            }
        }*/?>
    </div>
</div>