<?php
// autoload.php

// Autoloader for the database library
spl_autoload_register(function ($class) {
    $prefix = 'DatabaseLibrary\\\\';
    $base_dir = __DIR__ . '/lib/database/src/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

// Autoloader for your project classes
spl_autoload_register(function ($class) {
    $prefix = 'MiProyecto\\\\';
    $base_dir = __DIR__ . '/src/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});