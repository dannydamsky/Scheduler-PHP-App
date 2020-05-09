<?php

/**
 * CLI application bootstrap file.
 *
 * @since 2020-05-09
 * @author Danny Damsky <dannydamsky99@gmail.com>
 */

error_reporting(E_ALL | E_STRICT);

if (!defined('BASE_PATH')) {
    define('BASE_PATH', __DIR__);
}

use Base\Framework\App\ObjectManager;
use Base\Framework\Application;
use Base\Framework\Providers\ApplicationProvider;

/*
 * Validate PHP version.
 */
if (PHP_VERSION_ID < 70400) {
    throw new RuntimeException("Invalid PHP Version: Please use PHP 7.4.0 and higher.\n");
}

// Load the classes.
require __DIR__ . '/vendor/autoload.php';

// Initialize the ObjectManager - used for DI.
$objectManager = ObjectManager::getInstance();

// Initialize the application provider class and call the register method.
/** @var ApplicationProvider $applicationProvider */
$applicationProvider = $objectManager->get(ApplicationProvider::class);
$applicationProvider->register();

/** @var Application $application */
$application = $objectManager->get(Application::class);