<div class="block" id="comment-add-form">
    <h3>Добавить комментарий</h3>

    <div class="block__content">
        <form class="form" method="POST"
              action="/article/<?php echo $art['id'] . "-" . translit($art['title']); ?>#comment-add-form">
            <?php if (empty($errors)) {
                echo '<span style="color: green; font-weight:bold; margin-bottom: 10px; display: block; " > 
                        Комментарий успешно добавлен!
                      </span>';
            } else {
                echo '<span style="color: red; font-weight:bold; margin-bottom: 10px; display: block; "> '
                    . $errors['0'] .
                     '</span>';
            }
            ?>
            <div class="form__group">
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" class="form__control" name="name" placeholder="Имя"
                               value="<?php echo $postData['name']; ?>">
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form__control" name="email"
                               placeholder="Email (Не будет показан)"
                               value="<?php echo $postData['email']; ?>">
                    </div>
                </div>
            </div>
            <div class="form__group">
               <textarea name="text" class="form__control"
                         placeholder="Текст комментария ..."><?php echo $postData['text']; ?></textarea>
            </div>

            <div class="form__group">
                <input type="submit" class="form__control" name="do_post"
                       value="Добавить комментарий">
            </div>

        </form>
    </div>
</div>