<?php
if ( ! isset($appConfig)) {
    $appConfig = [];
}
/**
 * Set $appConfig locales
 * --------------------------------------------- 
 * 
 * max_upload_file 100MB
 */
$appConfig['import'] = [
    'extensions' => [
        'image' => ["jpeg","jpg","png"],
        'data'  => ["csv","xls","x-xls","xlsx"],
        'billFile' => ["pdf","zip"]
    ],
    'max_upload_file' => (pow(1024, 2) * 100), 
];