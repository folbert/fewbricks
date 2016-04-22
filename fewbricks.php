<?php

/*
Plugin Name: Fewbricks
Plugin URI: https://github.com/fewagency/fewbricks
Description: A module extension to Advanced Custom Fields
Author: Björn Folbert
Version: 1.0
Author URI: http://folbert.com
License: GPLv3
*/

namespace fewbricks;

use fewbricks\helpers;

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;

// Only perform requirement checks in admin system.
// If any requirements are not met, this should be discovered by devs before pushing to production so let's save
// some CPU cycles on the frontend by not running all these checks there.
if(is_admin()) {

    // If ACF is not present.
    if(!class_exists('acf')) {

        add_action('admin_notices', function () {

            echo '
              <div class="error notice">
                <p>You have activated the plugin "Fewbricks". In order to use it, please make sure that <a href="http://www.advancedcustomfields.com/">Advanced Custom Fields 5 Pro</a> is installed and activated.</p>
              </div>
            ';

        });

    } else if(!file_exists(plugin_dir_path(__FILE__) . '../acf-fewbricks-hidden/acf-fewbricks-hidden.php')) {
        // If acf-fewbricks-hidden is not where it's supposed to be. Note that this check does not tell us if
        // acf-fewbricks-hidden is activated or not.

        add_action('admin_notices', function () {

            echo '
              <div class="error notice">
                <p>You have activated the plugin "Fewbricks". In order to use it, please make sure that <a href="https://github.com/folbert/acf-fewbricks-hidden">Fewbricks Hidden Field</a> for Advanced Custom Fields is installed.</p>
              </div>
            ';

        });

    } else if(!file_exists(get_template_directory() . '/fewbricks')) {
        // Make sure that the fewbricks/fewbricks-directory has been moved to the template directory.

        add_action('admin_notices', function() {

            echo '
              <div class="error notice">
                <p>You have activated the plugin "Fewbricks". In order to use it, please make sure that you have copied the directory "fewbricks" in plugins/fewbricks/ to your theme directory. Read more under in the <a href="https://github.com/folbert/fewbricks/blob/master/README.md">README</a>.</p>
              </div>
            ';

        });

    } else {
        // So far, so good...

        // ... but let's also check that acf-fewbricks-hidden really have been activated.
        add_action('admin_init', function() {

            if (!is_plugin_active('acf-fewbricks-hidden/acf-fewbricks-hidden.php')) {

                add_action('admin_notices', function () {

                    echo '
                      <div class="error notice">
                        <h1>Important</h1><p>You have activated the plugin "Fewbricks". In order to use it, please make sure that <a href="https://github.com/folbert/acf-fewbricks-hidden">Fewbricks Hidden Field</a> for Advanced Custom Fields is activated.</p>
                      </div>
                    ';

                });

            }

        });

        // There is no way to check if a plugin is activated without using an earlier action than admin_init and
        // we don't want to postpone construct until then. So we construct Fewbricks here without being shure that
        // acf-fewbricks-hidden is activated.
        \fewbricks\construct();

    }

} else {
    // Not in admin system, so assume that all is good.

    \fewbricks\construct();

}

/**
 * Start Fewbricks
 */
function construct() {

    $fewbricks_lib_dir_path = __DIR__ . '/lib/';

    require_once($fewbricks_lib_dir_path . 'helpers.php');

    // Master-parent-Yoda-class
    require($fewbricks_lib_dir_path . 'brick.php');

    require($fewbricks_lib_dir_path . 'acf/field-group.php');
    require($fewbricks_lib_dir_path . 'acf/layout.php');

    $fewbricks_dev_mode = \fewbricks\helpers\is_fewbricks_in_developer_mode();

    /**
     * Autoloader for fewbricksclasses
     * @param $class
     */
    spl_autoload_register(function ($class)
    {

        $namespace_parts = explode('\\', $class);

        // Make sure that we are dealing with something in fewbricks
        if ($namespace_parts[0] === 'fewbricks') {

            $file_name = str_replace('_', '-', end($namespace_parts)) . '.php';

            if ($namespace_parts[1] === 'bricks') {

                $brick_path = get_template_directory() . '/fewbricks/bricks/' . $file_name;

                /** @noinspection PhpIncludeInspection */
                if(!@include($brick_path)) {

                    wp_die('<h1>Error message from Fewbricks.</h1><p>Could not locate brick ' . $brick_path . $file_name . '.</p>');

                }

            } else {

                $lib_path = __DIR__ . '/lib/acf/fields/' . $file_name;

                /** @noinspection PhpIncludeInspection */
                if (!@include($lib_path)) {

                    $template_path = get_template_directory() . '/fewbricks/fields/' . $file_name;

                    /** @noinspection PhpIncludeInspection */
                    if(!@include($template_path)) {

                        wp_die('<h1>Error message from Fewbricks.</h1><p>Could not locate field ' . $file_name . '. Looked in ' . $lib_path . ' and ' .$template_path . '.</p>');

                    }

                }

            }

        }

    });

    global $fewbricks_save_json;

    /**
     * Stuff that is only required in the backend doesnt needs to be required if local json is used.
     */
    if ((!\fewbricks\helpers\use_acf_json() && \fewbricks\helpers\acf_exists()) || $fewbricks_save_json === true) {

        $fewbricks_template_directory = get_template_directory() . '/';

        require($fewbricks_template_directory . 'fewbricks/common-fields/init.php');
        require($fewbricks_template_directory . 'fewbricks/field-groups/init.php');

    }

    /**
     * If we are in dev mode and have dumped fields theres no need to continue.
     */
    if ($fewbricks_dev_mode && isset($_GET['dumpfewbricksfields'])) {

        die();

    }

    /**
     * Lets add a menu item to the ACF menu
     */
    if ($fewbricks_dev_mode) {

        add_action('admin_menu', function() {

            \add_submenu_page('edit.php?post_type=acf-field-group', 'Fewbricks', 'Fewbricks', 'activate_plugins',
                'fewbricksdev',
                function () {
                    require_once(__DIR__ . '/admin/dev.php');
                });
        });

    }

    /**
     * Should we display info about the ACF fields?
     * FEWBRICKS_HIDE_ACF_INFO Gives us a way to hide info event if dev mode is activated
     */
    if (
        (!helpers\hide_acf_info()) ||
        (!defined('FEWBRICKS_HIDE_ACF_INFO') && $fewbricks_dev_mode === true)
    ) {

        require_once(__DIR__ . '/extras/acf-field-snitch/activate.php');

    }

}