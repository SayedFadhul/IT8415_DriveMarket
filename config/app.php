<?php
if (!defined('APP_BASE_URL')) {
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';

    if (strpos($scriptName, '/~u202301830/DriveMarket/') !== false) {
        define('APP_BASE_URL', '/~u202301830/DriveMarket/');
    } else {
        define('APP_BASE_URL', '/IT8415_DriveMarket-main/');
    }
}

if (!defined('APP_ROOT_PATH')) {
    define('APP_ROOT_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR);
}

if (!defined('APP_UPLOADS_PATH')) {
    define('APP_UPLOADS_PATH', APP_ROOT_PATH . 'assets' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR);
}

if (!defined('APP_UPLOADS_URL')) {
    define('APP_UPLOADS_URL', APP_BASE_URL . 'assets/uploads/');
}