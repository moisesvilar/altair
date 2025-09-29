<?php
// autoload.php

// Autoloader for the database library
spl_autoload_register(function ($class) {
    $prefix = 'DatabaseLibrary\\';
    $base_dir = __DIR__ . '/lib/database/src/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

// Autoloader for the auth library
spl_autoload_register(function ($class) {
    $prefix = 'AuthLibrary\\';
    $base_dir = __DIR__ . '/lib/auth/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

// Autoloader for the utils library
spl_autoload_register(function ($class) {
    $prefix = 'Utils\\';
    $base_dir = __DIR__ . '/lib/utils/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

// Autoloader for your project classes
spl_autoload_register(function ($class) {
    $prefix = 'Altair\\';
    $base_dir = __DIR__ . '/src/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    
    // Map of class names to their actual file locations
    $class_map = [
        'AltairService' => 'services/AltairService.php',
        'AuthService' => 'services/AuthService.php', 
        'DatabaseService' => 'services/DatabaseService.php',
        'UserProfile' => 'entities/UserProfile.php',
        'AuthResult' => 'entities/AuthResult.php',
        'Tenant' => 'entities/Tenant.php'
    ];
    
    // Check if class is in our map
    if (isset($class_map[$relative_class])) {
        $file = $base_dir . $class_map[$relative_class];
        if (file_exists($file)) {
            require $file;
            return;
        }
    }
    
    // Fallback to standard PSR-4 autoloading
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});