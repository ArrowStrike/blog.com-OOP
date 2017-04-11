<?php
session_start();
require_once "../models/functions.php";
require_once "../models/database.php";
$link = db_connect();

if (checkUser($link, $_SESSION["email"], $_SESSION["password"])) {
    redirect("/admin/index.php");
    exit();
}
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
                                <li><a href="/">Перейти на сайт</a>
                            </ul>

                        </nav>
                    </div>
                </div>
            </nav>

            <?php
            if ($_SESSION["error_auth"] === 1) {
                ?>
                <z><B>Неверные имя пользователя и/или пароль!</B></z>
                <?php
                unset ($_SESSION["error_auth"]);
                ?><br><br><?php
            }
            ?>
            <!-- Header (navbar) -->
            <form name="auth" action="/admin/models/authorization.php" method="post">
                <label><p>
                        E-mail<br>
                        <input type="text" name="email" required></p>
                </label>
                <label>
                    Password<br>
                    <input type="password" name="password" required>
                </label>
                <p>
                    <input type="submit" name="button_auth" value="Enter">
                </p>
            </form>

            <footer>
                <p>
                    Блог Влада<br>Copyright &copy; 2017
                </p>
            </footer>
    </div>
    </body>
</hmtl>
