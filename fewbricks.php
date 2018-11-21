<?php

/*
Plugin Name: Fewbricks
Plugin URI: https://github.com/folbert/fewbricks
Description: A module extension to Advanced Custom Fields
Author: Björn Folbert
Version: 2.0-alpha1
Author URI: https://folbert.com
License: GPLv3
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register autoload function.
 */
spl_autoload_register(function ($class) {

    $namespaceParts = explode('\\', $class);

    // Make sure that we are dealing with something in the Fewbricks namespace
    if (count($namespaceParts) > 1
        && $namespaceParts[0] === 'Fewbricks'
    ) {

        // The file name is the last item in the array
        $fileName = end($namespaceParts) . '.php';

        $path = __DIR__ . '/src/';

        // If there is sub folders in the path
        if (count($namespaceParts) > 2) {
            $path .= implode('/', array_slice($namespaceParts, 1, -1)) . '/';
        }

        $path .= $fileName;

        // Yes, by not checking of the file exists, we do get ugly error messages.
        // But we save some execution time by not checking if the file exists first.
        /** @noinspection PhpIncludeInspection */
        include $path;

    }

});

add_action('after_setup_theme', function () {
    \Fewbricks\Fewbricks::run();
});
