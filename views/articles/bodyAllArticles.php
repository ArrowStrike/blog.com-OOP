<?php
if (isset($_GET['q'])) { ?>
<div class="block">
    <h3>Результат поиска</h3><br>
    <?php
    Search::resultMessage($articleList, $total, $keyWord);
    }
    else { ?>
    <div class="block">
        <h3>Все статьи</h3>
        <?php
        }
        ?>
        <div class="block__content">
            <div class="articles articles__horizontal">
                <?php
                if (is_array($articleList)) {
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
                                    $artСat = Functions::appropriateCategory($categories, $article['category_id']); ?>
                                </a>
                                <div class="article__info__meta">
                                    <small>Категория:
                                        <a href="/<?php echo $artСat['title_translit']; ?>">
                                            <?php echo $artСat['title']; ?>
                                        </a>
                                    </small>
                                </div>
                                <div
                                    class="article__info__preview">
                                    <?php Functions::introArticle($article['text'], 70); ?>
                                </div>
                            </div>
                        </article>
                        <?php
                    }
                }
                ?>
            </div>
            <?php
            if ($total > Config::getConfig('articlePerPage') && is_array($articleList)) {
                echo $pagination->get();
            } ?>
        </div>
    </div>