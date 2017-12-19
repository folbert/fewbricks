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

        if($hook === 'custom-fields_page_fewbricksdev') {

            wp_enqueue_style( 'custom_wp_admin_css', plugins_url('../admin/assets/styles/styles.css', __FILE__));

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
