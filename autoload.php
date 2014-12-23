<?php

/**
 * @file autoload.php
 * 
 * This file is an implementation of PSR-4 loader
 * of this library. The code references the example
 * code provided by PHP-FIG.
 */

spl_autoload_register(function ($class) {

    // project-specific namespace prefix
    $prefix = 'Widgetarian\\Widgetfy';

    // base directory for the namespace prefix
    $base_dir = __DIR__ . '/src/';

    // does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // no, move to the next registered autoloader
        return;
    }

    // get the relative class name
    $relative_class = substr($class, $len);

    // separators with directory separators in the relative class name, append
    // with .php
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    // if the file exists, require it
    if (file_exists($file)) {
        require $file;
    }

});
