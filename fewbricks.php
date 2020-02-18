<?php

/*
Plugin Name: Fewbricks
Plugin URI: https://github.com/folbert/fewbricks
Description: A module extension to Advanced Custom Fields
Author: Björn Folbert
Version: 2.0.0-alpha3
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

            // First item will always be "Fewbricks" and we don't need that when building the path
            // Yes, by not checking of the file exists, we do get ugly error messages but we save some execution time.
            /** @noinspection PhpIncludeInspection */
            include __DIR__ . '/src/' . implode('/', array_slice($namespaceParts, 1)) . '.php';

        }

    });

}

add_action('acf/init', function () {
    \Fewbricks\Fewbricks::run();
});

if(!function_exists('fewbricks_check_version')) {

    add_action('init', 'fewbricks_check_version');

    function fewbricks_check_version()
    {

        require_once 'src/WP_AutoUpdate.php';

        // set auto-update params
        $plugin_current_version = \Fewbricks\Fewbricks::FEWBRICKS_VERSION;
        $plugin_remote_path = 'https://version.fewbricks2.folbert.com/version-info.php';
        $plugin_slug = plugin_basename(__FILE__);

        new WP_AutoUpdate($plugin_current_version, $plugin_remote_path, $plugin_slug);

    }

}
