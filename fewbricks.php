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

    $namespace_parts = explode('\\', $class);

    // Make sure that we are dealing with something in the Fewbricks namesoace
    if (count($namespace_parts) > 1
        && $namespace_parts[0] === 'Fewbricks'
    ) {

        // The file name is the last item in the array
        $file_name = end($namespace_parts) . '.php';

        $path = __DIR__ . '/src/';

        // If there is sub folders in the path
        if (count($namespace_parts) > 2) {
            $path .= implode('/', array_slice($namespace_parts, 1, -1)) . '/';
        }

        $path .= $file_name;

        // Yes, by not checking of the file exists, we do get ugly error messages.
        // But we save some execution time by not checking if the file exists first.
        include($path);

    }

});

add_action('after_setup_theme', function () {
    \Fewbricks\Fewbricks::run();
});

/*$fewbricks_lib_path = plugin_dir_path(__FILE__) . 'lib/';

require_once($fewbricks_lib_path . 'fewbricks.php');

add_action('after_setup_theme', function() {
    fewbricks\fewbricks::construct();
});*/

/**
 * Update related stuff
 */
//require_once($fewbricks_lib_path . 'wp-autoupdate.php');

/*add_action('init', function() {

    // set auto-update params
    $plugin_current_version = '1.6';
    $plugin_remote_path = 'http://fewbricks.folbert.com/update/update.php';
    $plugin_slug = plugin_basename(__FILE__);
    $license_user = 'null';
    $license_key = 'null';

    // only perform Auto-Update call if a license_user and license_key is given
    if ($license_user && $license_key && $plugin_remote_path) {
        new wp_autoupdate ($plugin_current_version, $plugin_remote_path, $plugin_slug, $license_user, $license_key);
    }

});*/
