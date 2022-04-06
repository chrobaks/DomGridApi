<?php
if ( ! isset($appConfig)) {
    $appConfig = [];
}
/**
 * Set $appConfig validation
 * --------------------------------------------- 
 */
$appConfig['validation'] = [
    "const" => [
        'autoId_11' => '/^[1-9][\d]{0,10}$/',
        'autoId_11_has_0' => '/^(0|[1-9][\d]{0,10})$/',
        'int_tiny' => '/^[1-9][\d]{0,3}$/i',
        'var_char' => '/^[\w\s\d\.\(\)öüäÖÜÄß,;_-]{1,250}$/i',
    ],
];
$appConfig['validation']['form'] = [
    'login' => [
        'required' => ['name', 'pass'],
        'rules'    => ['pass' => 'password_12', 'name' => '/^[\w\döüäÖÜÄß\.-]{8,250}$/i',]
    ],
    'user' => [
        'required' => ['id', 'name', 'role', 'realname', 'email', 'phone'],
        'optional' => ['fax'],
        'rules'    => ['id' => '/^[\d]{1,11}$/', 'role' => '/^(0|1)$/', 'email' => 'email', 'name' => '/^[\w\döüäÖÜÄß\.-]{8,250}$/i', 'realname' => '/^[\w\söüäÖÜÄß\.-]{5,250}$/i',]
    ],
    'appElement' => [
        'required' => [
            'id',
            'user_id',
            'app_element_name',
            'app_element_description',
            'app_element_source',
            'app_element_version',
            'stable_date_start',
            'stable_date_end',
            'app_element_environment',
            'app_element_type',
            'app_element_status',
        ],
        'rules'    => [
            'id' => $appConfig['validation']['const']['autoId_11_has_0'],
            'user_id' => $appConfig['validation']['const']['autoId_11'],
            'app_element_name' => $appConfig['validation']['const']['var_char'],
            'app_element_description' => $appConfig['validation']['const']['var_char'],
            'app_element_source' => $appConfig['validation']['const']['var_char'],
            'app_element_version' => $appConfig['validation']['const']['var_char'],
            'stable_date_start' => 'date',
            'stable_date_end' => 'date',
            'app_element_environment' => $appConfig['validation']['const']['int_tiny'],
            'app_element_type' => $appConfig['validation']['const']['int_tiny'],
            'app_element_status' => $appConfig['validation']['const']['int_tiny'],
        ]
    ],
    'appElementDelete' => [
        'required' => ['id'],
        'rules'    => [
            'id' => '/^[\d]{1,11}$/',
        ]
    ],
    'delete' => [
        'required' => ['id'],
        'rules'    => [
            'id' => '/^[\d]{1,11}$/',
        ]
    ],
    'customPackage' => [
        'required' => [
            'id',
            'user_id',
            'package_name',
            'package_description',
            'package_version',
        ],
        'rules'    => [
            'id' => $appConfig['validation']['const']['autoId_11_has_0'],
            'user_id' => $appConfig['validation']['const']['autoId_11'],
            'package_name' => $appConfig['validation']['const']['var_char'],
            'package_description' => $appConfig['validation']['const']['var_char'],
            'package_version' => $appConfig['validation']['const']['var_char'],
        ]
    ],
    'customElement' => [
        'required' => [
            'element_ids',
            'user_id',
            'custom_package_id',
        ],
        'rules'    => [
            'element_ids' => '/^[\d,]{1}[\d,]*$/',
            'user_id' => $appConfig['validation']['const']['autoId_11'],
            'custom_package_id' => $appConfig['validation']['const']['autoId_11'],
        ]
    ],
];
$appConfig['validation']["errorMsg"] = [
    'appElement' => [
        'id' => 'Die Daten-ID fehlt.',
        'user_id' => 'Die User-ID fehlt.',
        'app_element_name' => 'Der Name fehlt oder ist nicht korrekt.',
        'app_element_description' => 'Beschreibung fehlt oder ist nicht korrekt.',
        'app_element_source' => 'Dateiname fehlt oder ist nicht korrekt.',
        'app_element_version' => 'Die Version fehlt oder ist nicht korrekt.',
        'stable_date_start' => 'Startdatum fehlt oder ist nicht korrekt.',
        'stable_date_end' => 'Enddatum fehlt oder ist nicht korrekt.',
        'app_element_environment' => 'Der Bereich fehlt oder ist nicht korrekt.',
        'app_element_type' => 'Der Type fehlt oder ist nicht korrekt.',
        'app_element_status' => 'Der Status fehlt oder ist nicht korrekt.',
    ],
    'customPackage' => [
        'id' => 'Die Daten-ID fehlt.',
        'user_id' => 'Die User-ID fehlt.',
        'package_name' => 'Der Name fehlt oder ist nicht korrekt.',
        'package_description' => 'Beschreibung fehlt oder ist nicht korrekt.',
        'package_version' => 'Die Version fehlt oder ist nicht korrekt.',
    ],
    'customElement' => [
        'element_ids' => 'Keine Element-ID gefunden.',
        'user_id' => 'Die User-ID fehlt.',
        'custom_package_id' => 'Die Package-ID fehlt.',
    ],
    'appElementDelete' => [
        'id' => 'Die Daten-ID fehlt.',
    ],
    'profil' => [
        'id' => 'Die User-ID fehlt.',
        'email' => 'Der Emailempfänger fehlt oder ist nicht korrekt.',
        'name' => 'Kein korrekter Username.',
        'realname' => 'Dein Name (Mitarbeiter) fehlt oder ist nicht korrekt.',
        'phone' => 'Deine Telefonnummer fehlt oder ist nicht korrekt.',
    ],
    'user' => [
        'id' => 'Die User-ID fehlt.', 
        'email' => 'Der Emailempfänger fehlt oder ist nicht korrekt.', 
        'name' => 'Kein korrekter Username.',
        'pass' => 'Das Passwort fehlt oder ist nicht korrekt.',
        'realname' => 'Dein Name (Mitarbeiter) fehlt oder ist nicht korrekt.',
        'role' => 'Keine korrekte Benutzerrolle gefunden.',
        'phone' => 'Deine Telefonnummer fehlt oder ist nicht korrekt.',
    ],
    'login' => [ 
        'name' => 'Kein korrekter Username.',
        'pass' => 'Das Passwort fehlt oder ist nicht korrekt.',
    ],
];
