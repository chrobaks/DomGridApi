<?php
if ( ! isset($appConfig)) {
    $appConfig = [];
}
/**
 * Set $appConfig mysql
 * --------------------------------------------- 
 */
$appConfig['mysql'] = [
    'query' => [
        'loginUser' => "SELECT *  FROM user WHERE name = ? LIMIT 1",
        'appElement' => "SELECT app.id,app.user_id,
                            app_element_name,
                            app_element_description,
                            app_element_source,
                            app_element_version,
                            app_element_status,
                            app_element_type,
                            app_element_environment,
                            DATE_FORMAT(app.stable_date_start, '%d.%m.%Y') as stable_date_start,
                            DATE_FORMAT(app.stable_date_end, '%d.%m.%Y') as stable_date_end,
                            DATE_FORMAT(app.created_at, '%d.%m.%Y %H:%i') as created_at
                            FROM app_element as app  WHERE app.id = ? LIMIT 1",
        'appElementExist' => "SELECT id FROM app_element WHERE app_element_source = ? AND app_element_name = ? AND app_element_type = ? LIMIT 1",
        'appElementDelete' => "Delete FROM app_element WHERE id = ?",
        'appElements' => "SELECT app.id,
                            (SELECT name FROM user WHERE user.id=app.user_id LIMIT 1) as user_name,
                            app_element_name,
                            app_element_description,
                            app_element_source,
                            app_element_version,
                            (SELECT status_text FROM element_status WHERE status_value=app.app_element_status LIMIT 1) as app_element_status,
                            (SELECT type_text FROM element_type WHERE type_value=app.app_element_type LIMIT 1) as app_element_type,
                            (SELECT environment_text FROM environment_type WHERE environment_value=app.app_element_environment LIMIT 1) as app_element_environment,
                            DATE_FORMAT(app.stable_date_start, '%d.%m.%Y') as stable_date_start,
                            DATE_FORMAT(app.stable_date_end, '%d.%m.%Y') as stable_date_end,
                            DATE_FORMAT(app.created_at, '%d.%m.%Y %H:%i') as created_at
                            FROM app_element as app ",
        'appOptionStatus' => 'SELECT status_value as value, status_text as text FROM element_status ORDER BY id',
        'appOptionType' => 'SELECT type_value as value, type_text as text FROM element_type ORDER BY id',
        'appOptionEnvironment' => 'SELECT environment_value as value, environment_text as text FROM environment_type ORDER BY id',
        'elementTypeText' => 'SELECT GROUP_CONCAT(type_text) AS type_text FROM element_type',
        'elementTypeValue' => 'SELECT type_value FROM element_type  WHERE type_text = ? LIMIT 1',
        'customPackages' => 'SELECT DISTINCT cp.*, 
                            (SELECT count(ce.id) FROM custom_element ce WHERE cp.id = ce.custom_package_id) AS element_count,
                            (SELECT name FROM user WHERE user.id=cp.user_id LIMIT 1) as user_name 
                            FROM custom_package cp ORDER BY created_at',
        'customPackage' => 'SELECT DISTINCT cp.*, 
                            (SELECT count(ce.id) FROM custom_element ce WHERE cp.id = ce.custom_package_id) AS element_count,
                            (SELECT name FROM user WHERE user.id=cp.user_id LIMIT 1) as user_name 
                            FROM custom_package cp WHERE cp.id = ? LIMIT 1',
        'appCustomPackageElements' => "SELECT DISTINCT app.id,
                            (SELECT name FROM user WHERE user.id=app.user_id LIMIT 1) as user_name,
                            app_element_name,
                            app_element_description,
                            app_element_source,
                            app_element_version,
                            (SELECT status_text FROM element_status WHERE status_value=app.app_element_status LIMIT 1) as app_element_status,
                            (SELECT type_text FROM element_type WHERE type_value=app.app_element_type LIMIT 1) as app_element_type,
                            (SELECT environment_text FROM environment_type WHERE environment_value=app.app_element_environment LIMIT 1) as app_element_environment,
                            DATE_FORMAT(app.stable_date_start, '%d.%m.%Y') as stable_date_start,
                            DATE_FORMAT(app.stable_date_end, '%d.%m.%Y') as stable_date_end,
                            DATE_FORMAT(app.created_at, '%d.%m.%Y %H:%i') as created_at
                            FROM app_element as app
                            LEFT JOIN custom_element ce ON ce.app_element_id = app.id
                            WHERE app.id NOT IN ((SELECT app_element_id FROM custom_element cp WHERE cp.custom_package_id= ? )) ORDER BY app_element_type",
        'customElements' => 'SELECT DISTINCT ce.id,ce.user_id,ce.custom_package_id,ce.app_element_id,
                            cp.package_name,
                            ae.app_element_name,
                            ae.app_element_description,
                            app_element_source,
                            ae.app_element_version,
                            (SELECT status_text FROM element_status WHERE status_value=ae.app_element_status LIMIT 1) as app_element_status,
                            (SELECT type_text FROM element_type WHERE type_value=ae.app_element_type LIMIT 1) as app_element_type,
                            (SELECT environment_text FROM environment_type WHERE environment_value=ae.app_element_environment LIMIT 1) as app_element_environment,
                            DATE_FORMAT(ae.stable_date_start, "%d.%m.%Y") as stable_date_start,
                            DATE_FORMAT(ae.stable_date_end, "%d.%m.%Y") as stable_date_end
                            FROM custom_element ce 
                            LEFT JOIN app_element ae ON ae.id = ce.app_element_id
                            LEFT JOIN custom_package cp ON cp.id = ce.custom_package_id
                            WHERE custom_package_id = ? 
                            ORDER BY app_element_type',
        'customElement' => 'SELECT ce.id,ce.user_id,ce.custom_package_id,ce.app_element_id,
                            cp.package_name,
                            ae.app_element_name,
                            ae.app_element_description,
                            app_element_source,
                            ae.app_element_version,
                            (SELECT status_text FROM element_status WHERE status_value=ae.app_element_status LIMIT 1) as app_element_status,
                            (SELECT type_text FROM element_type WHERE type_value=ae.app_element_type LIMIT 1) as app_element_type,
                            (SELECT environment_text FROM environment_type WHERE environment_value=ae.app_element_environment LIMIT 1) as app_element_environment,
                            DATE_FORMAT(ae.stable_date_start, "%d.%m.%Y") as stable_date_start,
                            DATE_FORMAT(ae.stable_date_end, "%d.%m.%Y") as stable_date_end
                            FROM custom_element ce 
                            LEFT JOIN app_element ae ON ae.id = ce.app_element_id
                            LEFT JOIN custom_package cp ON cp.id = ce.custom_package_id
                            WHERE ce.id = ? 
                            LIMIT 1',
        'delete' => "Delete FROM %table% WHERE id = ?",
        'deleteDependency' => "Delete FROM %table% WHERE %column% = ?",
    ],
    'orderBy' => [
        'app_element' => 'app_element_type, app_element_status,app_element_environment',
    ],
    'tables' => [
        'user' => ['name', 'pass', 'role', 'realname', 'email', 'token'],
        'custom_package' => ['user_id', 'package_name','package_description','package_version'],
        'custom_element' => ['user_id', 'custom_package_id','app_element_id'],
        'app_element' => ['user_id', 'app_element_name', 'app_element_description', 'app_element_version', 'app_element_source', 'app_element_status', 'app_element_type', 'app_element_environment', 'stable_date_start', 'stable_date_end'],
    ],
    'column_alias' => [
        'app_element' => [
            'id' => 'Id',
            'user_name' => 'Author',
            'app_element_name' => 'AppElement Name',
            'app_element_description' => 'Beschreibung',
            'app_element_source' => 'Dateiname',
            'app_element_version' => 'Version',
            'app_element_status' => 'AppElement Status',
            'app_element_type' => 'AppElement Type',
            'app_element_environment' => 'AppElement Bereich',
            'stable_date_start' => 'gültig von',
            'stable_date_end' => 'gültig bis',
            'created_at' => 'erstellt am',
        ],
    ],
];