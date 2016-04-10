<?php

/*
Plugin Name: Fewbricks
Plugin URI: https://github.com/fewagency/fewbricks
Description: A module extension to Advanced Custom Fields
Author: Björn Folbert
Version: 0.9
Author URI: http://folbert.com
License: GPLv3
*/

namespace fewbricks;

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;

$fewbricks_template_directory = get_template_directory() . '/';

// If ACF is not present
if(!class_exists('acf')) {

    add_action('admin_notices', function () {

        echo '
          <div class="error notice">
            <p>You have activated the plugin "Fewbricks". In order to use it, please make sure that <a href="http://www.advancedcustomfields.com/">Advanced Custom Fields 5 Pro</a> is installed and activated.</p>
          </div>
        ';

    });

} else if(!file_exists(plugin_dir_path(__FILE__) . '../acf-hidden/acf-hidden.php')) {

    add_action('admin_notices', function () {

        echo '
      <div class="error notice">
        <p>You have activated the plugin "Fewbricks". In order to use it, please make sure that <a href="https://github.com/folbert/acf-fewbricks-hidden">Fewbricks Hidden Field</a> for Advanced Custom Fields is installed and activated.</p>
      </div>
    ';

    });

} else if(!file_exists($fewbricks_template_directory . 'fewbricks')) {

    add_action('admin_notices', function() {

        echo '
  <div class="error notice">
    <p>You have activated the plugin "Fewbricks". In order to use it, please make sure that you have copied the directory "fewbricks" in plugins/fewbricks/ to your theme directory. Read more under in the <a href="https://github.com/folbert/fewbricks/blob/master/README.md">README</a>.</p>
  </div>
';

    });

} else { // All requirements met

    /**
     * Set some variables that will be reused
     */
    $fewbricks_lib_dir_path = __DIR__ . '/lib/';

    /**
     * Require stuff to get us started
     */
    require_once($fewbricks_lib_dir_path . 'helpers.php');

    // Master-parent-Yoda-class
    require($fewbricks_lib_dir_path . 'brick.php');

    require($fewbricks_lib_dir_path . 'acf/field-group.php');
    require($fewbricks_lib_dir_path . 'acf/layout.php');

    $fewbricks_dev_mode = (defined('FEWBRICKS_DEV_MODE') && FEWBRICKS_DEV_MODE === true);

    /**
     * Autoloader for fewbricksclasses
     * @param $class
     */
    function autoloader($class)
    {

        $namespace_parts = explode('\\', $class);

        // Make sure that we are dealing with something in fewbricks
        if ($namespace_parts[0] === 'fewbricks') {

            $file_name = str_replace('_', '-', end($namespace_parts)) . '.php';

            if ($namespace_parts[1] === 'bricks') {

                $brick_path = get_template_directory() . '/fewbricks/bricks/' . $file_name;

                /** @noinspection PhpIncludeInspection */
                if(!@include($brick_path)) {

                    wp_die('<h1>Error message from Fewbricks.</h1><p>Could not locate brick ' . $file_name . '. Tried ' . $brick_path . '.</p>');

                }

            } else {

                $lib_path = __DIR__ . '/lib/acf/fields/' . $file_name;

                /** @noinspection PhpIncludeInspection */
                if (!@include($lib_path)) {

                    $template_path = get_template_directory() . '/fewbricks/fields/' . $file_name;

                    /** @noinspection PhpIncludeInspection */
                    if(!@include($template_path)) {

                        wp_die('<h1>Error message from Fewbricks.</h1><p>Could not locate field ' . $file_name . '. Tried ' . $lib_path . ' and ' .$template_path . '.</p>');

                    }

                }

            }

        }

    }

    spl_autoload_register(__NAMESPACE__ . '\\autoloader');

    global $fewbricks_save_json;

    /**
     * Stuff that is only required in the backend doesnt needs to be required if local json is used.
     */
    if (((!defined('FEWBRICKS_USE_ACF_JSON') || FEWBRICKS_USE_ACF_JSON === false) && function_exists('register_field_group')) || $fewbricks_save_json === true) {

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
    function add_admin_menu()
    {

        \add_submenu_page('edit.php?post_type=acf-field-group', 'Fewbricks', 'Fewbricks', 'activate_plugins',
            'fewbricksdev',
            function () {
                require_once(__DIR__ . '/admin/dev.php');
            });

    }

    if ($fewbricks_dev_mode) {

        add_action('admin_menu', __NAMESPACE__ . '\\add_admin_menu');

    }

    /**
     * Should we display info about the ACF fields?
     * FEWBRICKS_HIDE_ACF_INFO Gives us a way to hide info event if dev mode is activated
     */
    if (
        (defined('FEWBRICKS_HIDE_ACF_INFO') && FEWBRICKS_HIDE_ACF_INFO === false) ||
        (!defined('FEWBRICKS_HIDE_ACF_INFO') && $fewbricks_dev_mode === true)
    ) {

        require_once(__DIR__ . '/extras/acf-field-snitch/activate.php');

    }

}