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
    public static function addHooks()
    {

        add_action('admin_enqueue_scripts', __NAMESPACE__ . '\\Admin::applyStyles');
        add_action('admin_menu', __NAMESPACE__ . '\\Admin::editMenu');
        add_action('admin_menu', __NAMESPACE__ . '\\Exporter::maybeExportJson');

    }

    /**
     *
     */
    public static function applyStyles()
    {

        if (Helper::pageIsFewbricksAdminPage()) {

            wp_enqueue_style('fewbricks-admin', plugins_url('../assets/styles/styles.css', __FILE__), [],
                Helper::getInstalledVersionOrTimestamp());

            wp_enqueue_style('acf-input', acf_get_dir('assets/css/acf-input.css'), ['acf-global'],
                acf_get_setting('version'));

            wp_enqueue_script('fewbricks-admin-js', plugins_url('../assets/js/js.js', __FILE__), ['jquery'],
                Helper::getInstalledVersionOrTimestamp(), true);

        }

    }

    /**
     *
     */
    public static function editMenu()
    {

        add_submenu_page('edit.php?post_type=acf-field-group', 'Fewbricks', 'Fewbricks', 'activate_plugins',
            'fewbricksdev',
            function () {
                require_once(__DIR__ . '/../views/dev.view.php');
            });

    }

}
