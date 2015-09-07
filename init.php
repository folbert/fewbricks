<?php

namespace fewbricks;

require_once('lib/helpers.php');

// Master-parent-Yoda-class
require('lib/brick.php');

require('lib/acf/field-group.php');
require('lib/acf/layout.php');

/**
 * Autoloader for our brickclasses
 * @param $class
 */
function bricks_autoloader($class)
{

    $namespace_parts = explode('\\', $class);

    // Make sure that we are dealing with something in fewbricks
    if ($namespace_parts[0] === 'fewbricks') {

        $file_name = str_replace('_', '-', end($namespace_parts)) . '.php';

        if ($namespace_parts[1] === 'bricks') {

            /** @noinspection PhpIncludeInspection */
            require('project/bricks/' . $file_name);

        } else {

            /** @noinspection PhpIncludeInspection */
            require('lib/acf/fields/' . $file_name);
        }

    }

}

spl_autoload_register('fewbricks\bricks_autoloader');

global $fewbricks_save_json;

// Stuff that is only required in the backend needs not to be required if local json is used.
if (((!defined('FEWBRICKS_USE_ACF_JSON') || FEWBRICKS_USE_ACF_JSON === false) && function_exists('register_field_group')) || $fewbricks_save_json === true) {

    require('project/common-fields/init.php');
    require('project/field-groups/init.php');

}

/**
 * Lets add a menu item to the ACF menu
 */
function add_admin_menu()
{

    \add_submenu_page('edit.php?post_type=acf-field-group', 'fewbricks', 'Fewbricks', 'activate_plugins', 'fewbricks',
        function () {
            require_once(__DIR__ . '/admin/admin.php');
        });

}

add_action('admin_menu', __NAMESPACE__ . '\\add_admin_menu');

/**
 * Developer mode?
 */
if(defined('FEWBRICKS_DEV_MODE') && FEWBRICKS_DEV_MODE === true) {

    require_once(get_template_directory() . '/fewbricks/extras/acf-field-snitch/activate.php');

}