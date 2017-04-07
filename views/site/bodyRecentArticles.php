
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
    </div>