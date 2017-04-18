<?php

class Social
{
    public static function getSocialLinks($link)
    {
        $arrayWithLinks = array(
            'vk_url' => 'https://vk.com/id52976219',
            'github_url' => 'https://github.com/ArrowStrike/blog.com-OOP',
            'linkedIn_url' => 'https://www.linkedin.com/in/vladislavs-tarasenkovs/',
        );
        return $arrayWithLinks[$link];
    }
}