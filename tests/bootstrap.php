<?php

/**
 * PHPUnit Bootstrap for Laravel Backpack PHPStan Extension Tests
 */

require_once __DIR__ . '/../vendor/autoload.php';

// Set up test environment
putenv('APP_ENV=testing');

// Initialize PHPStan dependencies for testing
if (!defined('PHPUNIT_COMPOSER_INSTALL')) {
    define('PHPUNIT_COMPOSER_INSTALL', __DIR__ . '/../vendor/autoload.php');
}

// Helper function for tests
function fixture_path(string $path = ''): string
{
    return __DIR__ . '/fixtures' . ($path ? '/' . ltrim($path, '/') : '');
}

// Register test classes autoloader
spl_autoload_register(function ($class) {
    if (strpos($class, 'LaravelBackpackPhpstanExtension\\Tests\\') === 0) {
        $file = __DIR__ . '/' . str_replace('\\', '/', substr($class, strlen('LaravelBackpackPhpstanExtension\\Tests\\'))) . '.php';
        if (file_exists($file)) {
            require $file;
        }
    }
});