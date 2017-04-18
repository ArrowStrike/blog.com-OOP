<footer id="footer">
    <div class="container">
        <a href="/">
            <div class="footer__logo">
                <?php echo Config::getConfig('title') ?> &copy; 2017
            </div>
        </a>
        <nav class="footer__menu">
            <ul>
                <li><a href="/">Главная</a></li>
                <li><a href="/aboutMe">Обо мне</a></li>
                <li><a href="<?php echo Social::getSocialLinks('github_url') ?>" target="_blank">GitHub</a></li>
                <li><a href="<?php echo Social::getSocialLinks('linkedIn_url') ?>" target="_blank">LinkedIN</a></li>
                <li><a href="/copyright">Правообладателям</a></li>
            </ul>
        </nav>
    </div>
</footer>
</div>

</body>
</html>