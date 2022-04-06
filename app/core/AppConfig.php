<?php

class AppConfig
{
    private static $config;

    public static function setConfig ($config)
    {
        self::$config = $config;
    }

    public static function getConfig ($configId = '', $props = [])
    {
        $result = self::$config;

        if (!empty($configId) && isset(self::$config[$configId])) {
            $result = self::$config[$configId];
        }

        if (is_array($props) && !empty($props)) {
            $result = self::getProp($result, $props);
        }

        return $result;
    }

    private static function getProp ($config, $props)
    {
        $result = null;

        foreach($props as $prop) {
            if ($result === null) {
                if (isset($config[$prop])) {
                    $result = $config[$prop];
                } else {$result = null;break;}
            } else {
                if (isset($result[$prop])) {
                    $result = $result[$prop];
                } else {$result = null;break;}
            }
        }

        return $result;
    }
}
