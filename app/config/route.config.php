<?php
if ( ! isset($appConfig)) {
    $appConfig = [];
}
/**
 * Set $appConfig route
 * --------------------------------------------- 
 */
$appConfig['route'] = [
    'public' => [
        'login',
        'login.login',
    ],
    'private' => [
        'home',
        'home.relogin',
        'logout',
    ],
    'request' => [
        'public' => [],
        'private' => [
            'home.relogin',
        ]
    ],
    "customerLandingpage" => "login",
    "userLandingpage" => "home"
];

// Set private request route
$appConfig['route']['request']['private'] = array_merge($appConfig['route']['request']['public'], $appConfig['route']['request']['private']);

// Set admin page route
$appConfig['route']['admin'] = array_merge($appConfig['route']['private'],['user']);

// Set admin request route
$appConfig['route']['request']['admin'] = array_merge($appConfig['route']['request']['private'],[
    'request.user.updateUser',
    'request.user.addUser',
    'request.user.deleteUser',
    'request.appElement.add',
    'request.appElement.delete',
    'request.appElement.dataTable',
    'request.appElement.formEdit',
    'request.appElement.formDelete',
    'request.appElement.formAppElement',
    'request.appElement.formImport',
    'request.customPackage.add',
    'request.customPackage.delete',
    'request.customPackage.formDelete',
    'request.customPackage.formAdd',
    'request.customPackage.contentBox',
    'request.customPackage.contentPackage',
    'request.customElement.contentBox',
    'request.customElement.add',
    'request.customElement.delete',
    'request.customElement.formDelete',
    'request.customElement.formAdd',
]);

// Set request route controller
$appConfig['route']['requestController'] = ["user", "appElement", "customPackage", "customElement"];
