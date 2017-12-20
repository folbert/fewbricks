<?php

namespace Fewbricks;

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
    public static function applyHooks()
    {

        add_action('admin_enqueue_scripts', __NAMESPACE__ . '\\Admin::applyStyles');
        add_action('admin_menu', __NAMESPACE__ . '\\Admin::editMenu');

    }

    /**
     * @param $hook
     */
    public static function applyStyles($hook)
    {

        if (Helper::pageIsFewbricksAdminPage()) {

            wp_enqueue_style('fewbricks-admin', plugins_url('../admin/assets/styles/styles.css', __FILE__), [],
                Helper::getVersionOrTimestamp());

            wp_enqueue_style('acf-input', acf_get_dir('assets/css/acf-input.css'), ['acf-global'],
                acf_get_setting('version'));

            wp_enqueue_script('fewbricks-admin-js', plugins_url('../admin/assets/js/js.js', __FILE__), ['jquery'],
                Helper::getVersionOrTimestamp(), true);

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
                require_once(__DIR__ . '/../admin/views/dev.view.php');
            });

    }

    /**
     * @return bool|string
     */
    public static function getPhpCode()
    {

        $code = false;

        if (isset($_GET['fewbricks_generate_php'])
            && wp_verify_nonce($_GET['_wpnonce'], 'fewbricks_generate_php_rg8392god')
        ) {

            $code = 'banan';

        }

        return $code;

    }

}
