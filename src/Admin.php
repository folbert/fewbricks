<?php

namespace Fewbricks;

use Fewbricks\Helpers\Helper;

/**
 * Class Admin
 *
 * @package Fewbricks
 */
class Admin
{

    /**
     *
     */
    public static function add_hooks()
    {

        add_action('admin_enqueue_scripts', __NAMESPACE__ . '\\Admin::apply_styles');
        add_action('admin_menu', __NAMESPACE__ . '\\Admin::edit_menu');
        add_action('admin_menu', __NAMESPACE__ . '\\Exporter::maybe_export_json');

    }

    /**
     *
     */
    public static function apply_styles()
    {

        if (Helper::page_is_fewbricks_admin_page()) {

            wp_enqueue_style('fewbricks-admin', plugins_url('../assets/styles/styles.css', __FILE__), [],
                Helper::get_installed_version_or_timestamp());

            wp_enqueue_style('acf-input', acf_get_dir('assets/css/acf-input.css'), ['acf-global'],
                acf_get_setting('version'));

            wp_enqueue_script('fewbricks-admin-js', plugins_url('../assets/js/js.js', __FILE__), ['jquery'],
                Helper::get_installed_version_or_timestamp(), true);

        }

    }

    /**
     *
     */
    public static function edit_menu()
    {

        add_submenu_page('edit.php?post_type=acf-field-group', 'Fewbricks', 'Fewbricks', 'activate_plugins',
            'fewbricksdev',
            function () {
                require_once(__DIR__ . '/../views/dev.view.php');
            });

    }

}
