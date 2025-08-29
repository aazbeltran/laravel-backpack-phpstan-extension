<?php

declare(strict_types=1);

/**
 * Bootstrap file for Laravel Backpack PHPStan extension
 * This file is loaded early in the PHPStan analysis process
 */

// Define constants for Backpack components if not already defined
if (!defined('BACKPACK_CRUD_VERSION')) {
    define('BACKPACK_CRUD_VERSION', '6.0');
}

if (!defined('BACKPACK_BASSET_VERSION')) {
    define('BACKPACK_BASSET_VERSION', '1.3');
}

// Register global helpers if they exist
if (function_exists('backpack_url')) {
    // Backpack is available, no need to register additional helpers
} else {
    // Define minimal helper functions for static analysis
    if (!function_exists('backpack_url')) {
        function backpack_url(?string $path = null, array $parameters = [], ?bool $secure = null): string
        {
            return '';
        }
    }

    if (!function_exists('backpack_authentication_column')) {
        function backpack_authentication_column(): string
        {
            return 'email';
        }
    }

    if (!function_exists('backpack_avatar_url')) {
        function backpack_avatar_url($user): string
        {
            return '';
        }
    }

    if (!function_exists('backpack_user')) {
        function backpack_user(): ?\Illuminate\Contracts\Auth\Authenticatable
        {
            return null;
        }
    }

    if (!function_exists('backpack_auth')) {
        function backpack_auth(): \Illuminate\Contracts\Auth\Guard
        {
            throw new \RuntimeException('backpack_auth() not available during static analysis');
        }
    }

    if (!function_exists('crud_view')) {
        function crud_view(string $view, array $data = []): \Illuminate\Contracts\View\View
        {
            throw new \RuntimeException('crud_view() not available during static analysis');
        }
    }
}

// Register class aliases for better type resolution
if (!class_exists('CRUD')) {
    class_alias(\Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade::class, 'CRUD');
}

if (!class_exists('Widget')) {
    class_alias(\Backpack\CRUD\app\Library\Widget::class, 'Widget');
}

if (class_exists(\Backpack\Basset\Facades\Basset::class) && !class_exists('Basset')) {
    class_alias(\Backpack\Basset\Facades\Basset::class, 'Basset');
}