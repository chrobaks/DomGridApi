<?php
/**
 * Require Class Autoloader
 * -----------------------------------------------------------
 */
require_once 'AutoLoader.php';

/**
 * Get required files
 * -----------------------------------------------------------
 */
$files = Autoloader::getFiles(
    [
        CONFIG_PATH,
        CORE_PATH,
        MODEL_PATH,
        CONTROLLER_PATH,
        SERVICE_PATH,
        REQUEST_PATH,
    ],
    [
        CONFIG_PATH.'appConfig.php',
        CORE_PATH.'AppConfig.php',
        CORE_PATH.'PDOHandler.php',
        CORE_PATH.'BaseRequest.php',
    ]
);

/**
 * Set required files
 * -----------------------------------------------------------
 */
if (!empty($files)) {
    foreach($files as $file) {
        if (file_exists($file)) {
            require_once $file;
        }
    }
}

