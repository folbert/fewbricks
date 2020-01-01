<?php

namespace Fewbricks;

use Fewbricks\Helpers\Helper;

/**
 * Class Fewbricks
 *
 * @package Fewbricks
 */
class Fewbricks
{

    /**
     *
     */
    const FEWBRICKS_VERSION = '2.0.0-alpha';

    /**
     *
     */
    public static function add_hooks()
    {

        add_action('wp_loaded', __NAMESPACE__ . '\\Exporter::maybe_write_to_php_code_file');

    }

    /**
     * Makes sure that all requirements are met and if not, displays an error message
     * indicating what the problem is.
     *
     * @param bool $display_message
     *
     * @return bool Whether or not the requirements are met.
     */
    private static function check_requirements(bool $display_message = true)
    {

        $message = false;

        if (!Helper::acf_is_activated()) {

            $message
                = sprintf(__('You have activated the plugin "Fewbricks". In order to use it, please make sure that <a href="%1$s">Advanced Custom Fields 5 Pro</a> is installed and activated.',
                'fewbricks'), 'http://www.advancedcustomfields.com/');

        } else if (!Helper::fewbricks_hidden_is_activated()) {

            $message
                = sprintf(__('You have activated the plugin "Fewbricks". In order to use it, please make sure that %1$s is installed and activated.',
                'fewbricks'),
                '<a href="https://github.com/folbert/acf-fewbricks-hidden">Fewbricks Hidden Field</a> for Advanced Custom Fields');

        }

        if ($display_message && $message !== false) {

            add_action('admin_notices', function () use ($message) {
                echo '<div class="notice notice-warning"><p>' . $message . '</p></div>';
            });

        }

        // If no message, all is good
        return ($message === false);

    }

    /**
     *
     */
    public static function display_notices()
    {

        $message = false;

        if ($message !== false) {

            add_action('admin_notices', function () use ($message) {
                echo '<div class="notice notice-warning"><p>' . $message . '</p></div>';
            });

        }

    }

    /**
     *
     */
    public static function get_version()
    {

        return self::FEWBRICKS_VERSION;

    }

    /**
     *
     */
    private static function init()
    {

        self::display_notices();

        // More efficient to just start it than to first check if InfoPane is enabled.
        InfoPane::start_execution_timer();

        do_action('fewbricks/init');

        InfoPane::end_execution_timer();

        Helper::init_debug();

    }

    /**
     * Start me up!
     */
    public static function run()
    {

        // Only perform requirement checks in admin system.
        // If any requirements are not met, this should be discovered by devs before pushing to production so let's save
        // some CPU cycles on the frontend by not running all the checks there.
        if (!is_admin() || (is_admin() && self::check_requirements())) {

            self::init();

        }

        if (is_admin()) {
            Admin::add_hooks();
        }

        self::add_hooks();

    }

}
