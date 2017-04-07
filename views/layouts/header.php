<header id="header">
    <div class="header__top">
        <div class="container">
            <a href="/">
                <div class="header__top__logo">
                    <h1><?php echo Configs::getConfig('title') ?></h1>
                </div>
            </a>
            <nav class="header__top__menu">
                <ul>
                    <li><a href="/">Главная</a></li>
                    <li><a href="/aboutMe">Обо мне</a></li>
                    <li><a href="<?php echo Configs::getConfig('github_url') ?>" target="_blank">GitHub</a></li>
                    <li><a href="<?php echo Configs::getConfig('linkedIn_url') ?>" target="_blank">LinkedIN</a></li>
                    <li><a href="/admin/">Панель администратора</a></li>
                </ul>
            </nav>
        </div>
    </div>
    <div class="header__bottom">
        <div class="container">
            <nav>
                <ul>
                    <?php
                    foreach ($categories as $cat) {
                        ?>
                        <li>
                            <a href="/<?php echo ($cat['title_translit']); ?>">
                                <?php echo $cat['title']; ?>
                            </a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </nav>
        </div>
    </div>
</header>