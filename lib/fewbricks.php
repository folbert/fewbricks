<?php

namespace fewbricks;

use fewbricks\helpers;

/**
 * Class fewbricks
 * @package fewbricks
 */
class fewbricks {

    /**
     * @var
     */
    private static $messages;

    /**
     *
     */
    public static function construct()
    {

        self::init_messages();

        // Only perform requirement checks in admin system.
        // If any requirements are not met, this should be discovered by devs before pushing to production so let's save
        // some CPU cycles on the frontend by not running all these checks there.
        if(is_admin()) {

            // Check that crucial requirements are checked
            if( self::acf_exists() &&
                self::fewbricks_hidden_exists() &&
                self::fewbricks_template_dir_exists())
            {

                // We have to deal with checking if hidden field is activated in a special way.
                // This is because we can not check if class exists since ACF will init the class when its needed and
                // the fewbricks_hidden_exists-function used above only makes sure that the files exists, not if the
                // plugin really is activated.
                self::add_fewbricks_hidden_activated_check();

                // We are not 100% sure that Fewbricks Hidden is activated here but let's do this anyways
                // an have the activated_check-function display a message to the user if Fewbricks Hidden is not
                // active.
                self::init();

            }

        } else {
            // Not in admin system, so assume that all is good.

            self::init();

        }

    }

    /**
     *
     */
    private static function init()
    {

        global $fewbricks_save_json;

        $fewbricks_lib_dir_path = __DIR__ . '/';

        require($fewbricks_lib_dir_path . 'helpers.php');
        require($fewbricks_lib_dir_path . 'brick.php');
        require($fewbricks_lib_dir_path . 'acf/field-group.php');
        require($fewbricks_lib_dir_path . 'acf/layout.php');

        spl_autoload_register(['self', 'autoload']);

        if (!helpers\use_acf_json() || $fewbricks_save_json === true) {

            $project_files_base_path = apply_filters(
                'fewbricks/project_files_base_path',
                get_stylesheet_directory() . '/fewbricks'
            );

            require($project_files_base_path . '/common-fields/init.php');
            require($project_files_base_path . '/field-groups/init.php');

        }

        self::do_developer_mode();

    }

    /**
     * @param $class
     */
    private static function autoload($class)
    {

        $namespace_parts = explode('\\', $class);

        // Make sure that we are dealing with something in fewbricks
        if ($namespace_parts[0] === 'fewbricks') {

            $file_name = str_replace('_', '-', end($namespace_parts)) . '.php';

            // If are dealing with a brick
            if ($namespace_parts[1] === 'bricks') {

                self::autoload_brick($file_name);

            } else {
                // User wants a field

                self::autoload_field($file_name);

            }

        }

    }

    /**
     * @param $file_name
     */
    private static function autoload_brick($file_name)
    {

        $project_files_base_path = apply_filters(
            'fewbricks/project_files_base_path',
            get_stylesheet_directory() . '/fewbricks'
        );

        $path = $project_files_base_path . '/bricks/' . $file_name;

        if(is_file($path)) {

            include($path);

        } else {

            wp_die('
              <h1>Error message from Fewbricks.</h1>
              <p>Could not locate brick file ' . $path . '.</p>
            ');

        }

    }

    /**
     * @param $file_name
     */
    private static function autoload_field($file_name)
    {

        $file_found = false;

        // Lets first look at the custom lib directory in case custom fields were created
        // to overrule the one that came with Fewbricks.
        $template_path = get_stylesheet_directory() . '/fewbricks/acf/fields/' . $file_name;

        if (is_file($template_path)) {

            include($template_path);
            $file_found = true;

        } else {

            $lib_path = __DIR__ . '/acf/fields/' . $file_name;

            if(is_file($lib_path)) {

                include($lib_path);
                $file_found = true;

            }

        }

        if(!$file_found) {

            wp_die('
              <h1>Error message from Fewbricks.</h1>
              <p>Could not locate field ' . $file_name . '.<br>
              I looked in ' . $template_path . ' and ' . $lib_path . '.</p>
            ');

        }

    }

    /**
     *
     */
    private static function do_acf_info()
    {

        //FEWBRICKS_HIDE_ACF_INFO Gives us a way to hide info event if dev mode is activated
        if (!helpers\hide_acf_info()) {

            require_once(__DIR__ . '/../extras/acf-field-snitch/activate.php');

        }

    }

    /**
     *
     */
    private static function do_developer_mode()
    {

        if (helpers\is_fewbricks_in_developer_mode()) {

            // No use in continuting if we have dumped info
            if(isset($_GET['dumpfewbricksfields'])) {

                die();

            } else {

                add_action('admin_menu', function() {

                    \add_submenu_page('edit.php?post_type=acf-field-group', 'Fewbricks', 'Fewbricks', 'activate_plugins',
                        'fewbricksdev',
                        function () {
                            require_once(__DIR__ . '/../admin/dev.php');
                        });
                });

            }

            self::do_acf_info();

        }

    }

    /**
     *
     */
    private static function acf_exists()
    {

        $acf_exists = class_exists('acf');

        // If ACF is not present.
        if(!$acf_exists) {

            $acf_exists = false;

            add_action('admin_notices', function () {

                echo self::$messages['acf_missing'];

            });

        }

        return $acf_exists;

    }

    /**
     * @return bool
     */
    private static function fewbricks_hidden_exists()
    {

        $fewbricks_hidden_exists = file_exists(plugin_dir_path(__FILE__) . '../../acf-fewbricks-hidden/acf-fewbricks-hidden.php');

        if(!$fewbricks_hidden_exists) {
            // If acf-fewbricks-hidden is not where it's supposed to be. Note that this check does not tell us if
            // acf-fewbricks-hidden is activated or not.

            $fewbricks_hidden_exists = false;

            add_action('admin_notices', function () {

                echo self::$messages['fewbricks_hidden_missing'];

            });

        }

        return $fewbricks_hidden_exists;

    }

    /**
     * @return mixed
     */
    private static function fewbricks_template_dir_exists()
    {

        $project_files_base_path = apply_filters(
            'fewbricks/project_files_base_path',
            get_stylesheet_directory() . '/fewbricks'
        );

        $fewbricks_template_dir_exists = file_exists($project_files_base_path);

        if(!$fewbricks_template_dir_exists) {
            // Make sure that the fewbricks/fewbricks-directory has been moved to the template directory.

            add_action('admin_notices', function () {

                echo self::$messages['fewbricks_template_dir_missing'];

            });

        }

        return $fewbricks_template_dir_exists;

    }

    /**
     *
     */
    private static function add_fewbricks_hidden_activated_check()
    {

        // ... but let's also check that acf-fewbricks-hidden really have been activated.
        add_action('admin_init', function() {

            if (!is_plugin_active('acf-fewbricks-hidden/acf-fewbricks-hidden.php')) {

                add_action('admin_notices', function () {

                    echo self::$messages['fewbricks_hidden_missing'];

                });

            }

        });

    }

    /**
     *
     */
    private static function init_messages()
    {

        self::$messages = [];

        self::$messages['acf_missing'] = '
          <div class="error notice">
            <p>You have activated the plugin "Fewbricks". In order to use it, please make sure that <a href="http://www.advancedcustomfields.com/">Advanced Custom Fields 5 Pro</a> is installed and activated.</p>
          </div>';

        self::$messages['fewbricks_hidden_missing'] = '
            <div class="error notice">
              <p>You have activated the plugin "Fewbricks". In order to use it, please make sure that <a href="https://github.com/folbert/acf-fewbricks-hidden">Fewbricks Hidden Field</a> for Advanced Custom Fields is installed and activated.</p>
            </div>
        ';

        self::$messages['fewbricks_template_dir_missing'] = '
            <div class="error notice">
              <p>You have activated the plugin "Fewbricks". In order to use it, please make sure that you have copied the directory "fewbricks" in plugins/fewbricks/ to your theme directory or placed it at the path that you have specified using the filter fewbricks/project_files_base_path. Read more in the <a href="https://github.com/folbert/fewbricks/blob/master/README.md">README</a> (search for "hidden").</p>
          </div>
        ';

    }

}