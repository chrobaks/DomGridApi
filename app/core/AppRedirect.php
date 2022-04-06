<?php

class AppRedirect
{
    public static function setHeader ($url, $getArr = [])
    {
        if (!empty($getArr)) { $url .= implode('/', $getArr);  }

        header('Location: ' . $url);
        die();
    }
}
