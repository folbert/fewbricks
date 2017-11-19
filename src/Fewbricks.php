<?php

namespace Fewbricks;

/**
 * Class Fewbricks
 *
 * @package Fewbricks
 */
class Fewbricks
{

    /**
     * Start me up!
     */
    public static function run()
    {

        // Only perform requirement checks in admin system.
        // If any requirements are not met, this should be discovered by devs before pushing to production so let's save
        // some CPU cycles on the frontend by not running all these checks there.
        if (!is_admin() || (is_admin() && self::check_requirements())) {

            self::init();

        }

    }

    /**
     *
     */
    private static function init()
    {

        $project_files_base_path = Helpers::get_project_files_base_path();
        require($project_files_base_path . '/init.php');

        AcfFieldSnitch::init();

    }

    /**
     * Makes sure that all requirements are met and if not, displays an error message
     * indicating what the problem is.
     *
     * @param bool $display_message
     *
     * @return bool Whether or not the requirements are met.
     */
    private static function check_requirements($display_message = true)
    {

        $message = false;

        if (!Helpers::acf_is_activated()) {

            $message
                = sprintf(__('You have activated the plugin "Fewbricks". In order to use it, please make sure that <a href="%1$s">Advanced Custom Fields 5 Pro</a> is installed and activated.',
                'fewbricks'), 'http://www.advancedcustomfields.com/');

        } elseif (!Helpers::fewbricks_hidden_is_activated()) {

            $message = sprintf(__('You have activated the plugin "Fewbricks". In order to use it, please make sure that %1$s is installed and activated.', 'fewbricks'), '<a href="https://github.com/folbert/acf-fewbricks-hidden">Fewbricks Hidden Field</a> for Advanced Custom Fields');

        } elseif(!Helpers::project_init_file_exists()) {

            $message = sprintf(__('You have activated the plugin "Fewbricks". In order to use it, please make sure that you have copied the directory "fewbricks" in plugins/fewbricks/ to your theme directory or placed it at the path that you have specified using the filter fewbricks/project_files_base_path (currently <code>%1$s</code>). Also make sure that there is a file in that directory named "init.php"'), Helpers::get_project_files_base_path());

        }

        if ($display_message && $message !== false) {

            add_action('admin_notices', function() use ($message) {
                echo '<div class="error notice"><p>' . $message . '</p></div>';
            });

        }

        // If no message, all is good
        return ($message === false);

    }

}
