<?php

/**
 * Set APP NAME & APP PATH & ENVIROMENT settings 
 * --------------------------------------------- 
 */
if ($_SERVER['SERVER_NAME'] === '127.0.0.1' || $_SERVER['SERVER_NAME'] === 'localhost') {
    define('APP_Name', 'DomGridApi');
    define('ENVIROMENT', 'localhost');
} else {
    define('APP_Name', '[%YOUR-PRODUCTION-DOMAIN%]');
    define('ENVIROMENT', 'production');
}

define('APP_PATH', dirname(__DIR__).DIRECTORY_SEPARATOR);
define('CORE_PATH', APP_PATH.'core'.DIRECTORY_SEPARATOR);
define('INC_PATH', APP_PATH.'inc'.DIRECTORY_SEPARATOR);
define('CONFIG_PATH', APP_PATH.'config'.DIRECTORY_SEPARATOR);
define('CONTROLLER_PATH', APP_PATH.'controller'.DIRECTORY_SEPARATOR);
define('MODEL_PATH', APP_PATH.'model'.DIRECTORY_SEPARATOR);
define('SERVICE_PATH', APP_PATH.'service'.DIRECTORY_SEPARATOR);
define('REQUEST_PATH', APP_PATH.'request'.DIRECTORY_SEPARATOR);
define('FORM_PATH', APP_PATH.'form'.DIRECTORY_SEPARATOR);
define('VIEW_PATH', APP_PATH.'view'.DIRECTORY_SEPARATOR);
define('VIEW_PDF_PATH', VIEW_PATH.'pdf'.DIRECTORY_SEPARATOR);
define('VENDOR_PATH', str_replace('app', 'vendor', APP_PATH));
define('SNAPPY_PATH', VENDOR_PATH.'snappy/wkhtmltox/bin/wkhtmltopdf');


/**
 * Set PUBLIC PATH settings
 * --------------------------------------------- 
 */
define('PUBLIC_PATH', str_replace('app', 'public', APP_PATH));
define('CSS_PATH', PUBLIC_PATH.'css'.DIRECTORY_SEPARATOR);
define('JS_PATH', PUBLIC_PATH.'js'.DIRECTORY_SEPARATOR);
define('IMAGE_PATH', PUBLIC_PATH.'image'.DIRECTORY_SEPARATOR);
define('DOMGRID_JS_PATH', JS_PATH.'app'.DIRECTORY_SEPARATOR);
define('IMPORT_PATH', str_replace(DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR.'import'.DIRECTORY_SEPARATOR, APP_PATH));
define('EXPORT_PATH', str_replace(DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR.'export'.DIRECTORY_SEPARATOR, APP_PATH));
define('PDF_PATH', str_replace(DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR.'pdf'.DIRECTORY_SEPARATOR, APP_PATH));
define('LOG_LOCAL_PATH', str_replace(DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR.'log-local'.DIRECTORY_SEPARATOR, APP_PATH));
define('INVOICE_DISPATCH_PATH', str_replace('app', 'invoice_dispatch'.DIRECTORY_SEPARATOR, APP_PATH));

// Set whole public path
define('CSS_URL', 'public/css/');
define('JS_URL', 'public/js/');
define('IMAGE_URL', 'public/image/');

/**
 * Set DATABASE settings
 * --------------------------------------------- 
 */
if (ENVIROMENT === 'localhost') {
    define('DB_HOST', '[%YOUR-LOCAL-DB-HOST%]');
    define('DB_NAME', '[%YOUR-LOCAL-DB-NAME%]');
    define('DB_USER', '[%YOUR-LOCAL-DB-USER%]');
    define('DB_PASS', '[%YOUR-LOCAL-DB-PASS%]');
} else {  // DB-Setttings with docker container
    define('DB_HOST', '[%YOUR-PRODUCTION-DB-HOST%]');
    define('DB_NAME', '[%YOUR-PRODUCTION-DB-NAME%]');
    define('DB_USER', '[%YOUR-PRODUCTION-DB-USER%]');
    define('DB_PASS', '[%YOUR-PRODUCTION-DB-PASS%]');
}

/**
 * Set SESSION COOKIE NAME
 * --------------------------------------------- 
 */
define('SESS_COOKIE_NAME', '[%YOUR-SESSION-COOKIE-IDENTIFIER%]');
