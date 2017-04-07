<div class="block">
    <a href="#comment-add-form">Добавить свой</a>
    <h3>Комментарии</h3>
    <div class="block__content">
        <div class="articles articles__vertical">
            <?php
            $errors = array(null);
            $postData = $_POST;
            if (!empty($postData))//если была нажата кнопка
            {
                $errors = array();
                if ($postData['name'] == '') {
                    $errors[] = 'Введите имя!';
                }
                /* if ($postData['nickname'] == '') {
                       $errors[] = 'Введите Ваш никнейм!';
                   }*/
                if ($postData['email'] == '') {
                    $errors[] = 'Введите Email!';
                }
                if ((filter_var($postData['email'], FILTER_VALIDATE_EMAIL)) == false) {
                    $errors[] = 'Введите правильный Email!';
                }
                if ($postData['text'] == '') {
                    $errors[] = 'Введите текст комментария!';
                }
                if (empty($errors)) {
                    mysqli_query($connection, "INSERT INTO comments (author, nickname, email, text, pubdate, articles_id) 
                                              VALUES ('" . $postData['name'] . "',
                                              '" . $postData['nickname'] . "',
                                              '" . $postData['email'] . "',
                                              '" . $postData['text'] . "',
                                               NOW(),
                                              '" . $art['id'] . "')");
                    //добавить коммент

                    unset($_POST);
                    unset($postData);
                    //   $zaza= "http://blog.com/pages/article.php?id=".$art['id']."#comment-add-form";
                    //   echo "<script language='JavaScript' type='text/javascript'>window.location.replace('zaza')</script>";
                    //       var_dump($POST['text']);
                    //       die();
                }
            }
            ?>
            <?php
            $comments = mysqli_query($connection, "SELECT * FROM comments 
                                                  WHERE articles_id = " . (int)$art['id'] . " ORDER BY id DESC");
            if (mysqli_num_rows($comments) <= 0) {
                echo "Нет комментариев!";
            }
            while ($comment = mysqli_fetch_assoc($comments)) {
                ?>
                <article class="article">
                    <div class="article__image"
                         style="background-image:
                             url(https://www.gravatar.com/avatar/<?php echo md5($comment['email']); ?>?s=125);">
                    </div>
                    <div class="article__info">
                        <a href="/article/<?php echo $comment['articles_id']; ?>">
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
            ?>

        </div>
    </div>
</div>