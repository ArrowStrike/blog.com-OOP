<?php

/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 07-Apr-17
 * Time: 1:24
 */
class Configs
{
    public static function getConfig($config)
    {
        $configsPath = ROOT . '/config/configs.php';
        $configs = include($configsPath);

        return $configs[$config];
    }

}