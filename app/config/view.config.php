<?php
/**
 * Declare $appConfig if not exsist
 * --------------------------------------------- 
 */
if ( ! isset($appConfig)) { $appConfig = []; }

/**
 * Set $appConfig view title, appTpl
 * --------------------------------------------- 
 */
$appConfig['view'] = [
    'title' => 'DomGrid Admin Interface',
    'appTpl' => 'app.tpl',
    'lang_default' => 'de',
];

/**
 * Set $appConfig view url with ENVIROMENT setting
 * --------------------------------------------- 
 */
switch (ENVIROMENT) {
    case ('localhost'): // Local host http
    case ('127.0.0.1'): // Local host http 
        $appConfig['view']['url'] = 'http://localhost/'.APP_Name.'/';
    break;
    default: // https for trboapi.netcodev.de
        $appConfig['view']['url'] = 'https://'.APP_Name.'/';
}