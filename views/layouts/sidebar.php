<div class="block">
    <h3>Приветствую тебя, дорогой друг!</h3>
    <div class="block__content">
        <script type="text/javascript"
                src="//rf.revolvermaps.com/0/0/6.js?i=5knsrjy0031&amp;m=7&amp;s=330&amp;c=ff0000&amp;cr1=00ff6c&amp;f=arial&amp;l=1&amp;bv=0&amp;v0=-10&amp;z=11&amp;rx=40&amp;lx=120&amp;ly=280&amp;rs=0"
                async="async"></script>
    </div>
</div>
<div class="block" id="comment-add-form">
    <h3>Поиск статьи по отрывку</h3>

    <div class="block__content">
        <form class="form" action="/search">
            <div class="form__group">
                <input type="text" class="form__control" name="q" placeholder="Введите запрос"
                       value="" required>
            </div>
            <input type="submit" class="form__control"
                   value="Найти">
        </form>
    </div>


</div>
<div class="block">
    <h3>Топ читаемых статей</h3>
    <div class="block__content">
        <div class="articles articles__vertical">
            <?php
            foreach ($articleToSidebar as $article) {
                ?>
                <article class="article">
                    <a href="/article/<?php echo($article['title_translit']); ?>">
                        <div class="article__image"
                             style="background-image: url(/public/static/imagesPreview/<?php echo $article['image']; ?>);">
                        </div>
                    </a>
                    <div class="article__info">
                        <a href="/article/<?php echo $article['title_translit']; ?>">
                            <?php Functions::introArticle($article['title'], 50);
                            $art_cat = Functions::compareCategory($categories, $article['category_id']) ?>
                        </a>
                        <div class="article__info__meta">

                            <small>Категория: <a
                                    href="/<?php echo $art_cat['title_translit']; ?>">
                                    <?php echo $art_cat['title']; ?></a>
                            </small>
                        </div>
                        <div class="article__info__preview"><?php Functions::introArticle($article['text'], 70); ?>
                        </div>
                    </div>
                </article>
                <?php
            }
            ?>
        </div>
    </div>
</div>
<div class="block">
    <h3>Последние комментарии</h3>
    <div class="block__content">
        <div class="articles articles__vertical">
            <?php
            foreach ($commentsToSidebar as $comment) {
                ?>
                <article class="article">
                    <div class="article__image"
                         style="background-image:
                             url(https://www.gravatar.com/avatar/<?php echo md5($comment['email']); ?>?s=125);">
                    </div>
                    <div class="article__info">
                        <a href="/article/<?php echo Articles::getTitleTranslitOfArticle($comment['articles_id']);?>">
                            <?php echo $comment['author']; ?>
                        </a>
                        <div class="article__info__meta"></div>
                        <div class="article__info__preview"><?php Functions::introArticle($comment['text'], 70); ?>
                        </div>
                    </div>
                </article>
                <?php
            }
            ?>

        </div>
    </div>
</div>
