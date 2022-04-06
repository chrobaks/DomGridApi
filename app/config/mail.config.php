<?php
if ( ! isset($appConfig)) {
    $appConfig = [];
}
/**
 * Set $appConfig mail
 * --------------------------------------------- 
 */
$appConfig['mail'] = [
    "default" => [
        'emailHost' => '',
        'emailPass' => '',
        'emailUser' => '',
        'emailFrom' => '',
        'replyTo' => '',
    ]
];