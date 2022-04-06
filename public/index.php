<?php
/**
 * Debug Modus
 */
if ($_SERVER['REMOTE_ADDR'] === '127.0.0.1') {
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
}

// ini_set('memory_limit', '1024M');

/**
 * Load Requires
 */
require_once '../app'.DIRECTORY_SEPARATOR.'define'.DIRECTORY_SEPARATOR.'appDefines.php';
require_once INC_PATH.'autoloader.inc.php';

/**
 * Start App Session
 */
AppSession::startSession();

/**
 * Set App Config
 */
$appConfig = $appConfig ?? '';
if (empty($appConfig)) {
    die('No config file found. Did you forgot something');
}
AppConfig::setConfig($appConfig);

/**
 * Instance Index controller
 */
$IndexController = IndexController::get_instance();

/**
 * Set view if is page route
 * else set ajax request
 */
if ($IndexController->setRouteController()) {
    $view = $IndexController->getView();
    include_once VIEW_PATH.$view['appTpl'].'.php';
} else {
    $IndexController->setRequest();
};