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

        // First item will always be "Febwricks" and we dont need that when building the path
        // Yes, by not checking of the file exists, we do get ugly error messages.
        // But we save some execution time by not checking if the file exists first.
        include __DIR__ . '/src/' . implode('/', array_slice($namespaceParts, 1)) . '.php';

    }

});

add_action('acf/init', function () {
    \Fewbricks\Fewbricks::run();
});
