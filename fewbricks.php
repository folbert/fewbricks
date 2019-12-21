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

if(file_exists(__DIR__.'/vendor/autoload.php')) {
    require_once __DIR__.'/vendor/autoload.php';
} else {

    // Lets use a custom autoload regardless of if Fewbricks has been installed using Composer or not.
    spl_autoload_register(function ($class) {

        $namespaceParts = explode('\\', $class);

        // Make sure that we are dealing with something in the Fewbricks namespace
        if (count($namespaceParts) > 1
            && $namespaceParts[0] === 'Fewbricks'
        ) {

            // First item will always be "Febwricks" and we don't need that when building the path
            // Yes, by not checking of the file exists, we do get ugly error messages but we save some execution time.
            /** @noinspection PhpIncludeInspection */
            include __DIR__ . '/src/' . implode('/', array_slice($namespaceParts, 1)) . '.php';

        }

    });

}

add_action('acf/init', function () {
    \Fewbricks\Fewbricks::run();
});
