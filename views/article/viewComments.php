<div class="block">
    <a href="#comment-add-form">Добавить свой</a>
    <h3>Комментарии</h3>
    <div class="block__content">
        <div class="articles articles__vertical">
            <?php
            if ($commentsList == null) {
                echo "Нет комментариев!";
            } else {
                foreach ($commentsList as $comment) {
                    ?>
                    <article class="article">
                        <div class="article__image"
                             style="background-image:
                                 url(https://www.gravatar.com/avatar/<?php echo md5($comment['email']); ?>?s=125);">
                        </div>
                        <div class="article__info">
                            <a href="/article/<?php
                            echo Articles::getTitleTranslitOfArticle($comment['articles_id']); ?>">
                                <?php echo $comment['author']; ?>
                            </a>
                            <div class="article__info__meta">
                                <?php echo date('H:i d-m-y', strtotime($comment['pubdate'])); ?>
                            </div>
                            <div class="article__info__preview">
                                <?php echo $comment['text']; ?>
                            </div>
                        </div>
                    </article>
                    <?php
                }
            }
            ?>

        </div>
    </div>
</div>