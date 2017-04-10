<div class="block" id="comment-add-form">
    <h3>Добавить комментарий</h3>
    <div class="block__content">
        <form class="form" method="POST"
              action="/article/<?php echo $articleItem['title_translit']; ?>#comment-add-form">

            <?php Comments::setResultOfValidation($logsOfValidation); ?>

            <div class="form__group">
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" class="form__control" name="name" placeholder="Имя"
                               value="<?php echo $logsOfValidation['commentUserName'] ?>">
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form__control" name="email"
                               placeholder="Email (Не будет показан)"
                               value="<?php echo $logsOfValidation['commentUserEmail'] ?>">
                    </div>
                </div>
            </div>
            <div class="form__group">
               <textarea name="text" class="form__control"
                         placeholder="Текст комментария ..."><?php echo $logsOfValidation['commentText'] ?></textarea>
            </div>

            <div class="form__group">
                <input type="submit" class="form__control" name="submit"
                       value="Добавить комментарий">
            </div>

        </form>
    </div>
</div>