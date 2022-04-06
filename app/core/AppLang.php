<?php

class AppLang
{
    public static function getLang($lang, $key = "")
    {
        $config = AppConfig::getConfig('lang');
        $result = [];

        if (isset($config['translation'][$lang])) {
            $result = (empty($key))
                ? $config['translation'][$lang]
                : ((isset($config['translation'][$lang][$key])) ? $config['translation'][$lang][$key] : '');
        }

        return $result;
    }

    public static function getLangSelection()
    {
        $config = AppConfig::getConfig('lang');

        return (isset($config['lang_selection'])) ? $config['lang_selection'] : '';
    }
}