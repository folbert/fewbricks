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

        add_action('admin_menu', __NAMESPACE__ . '\\Admin::adminMenu');

    }

    /**
     *
     */
    public static function adminMenu()
    {

        add_submenu_page('edit.php?post_type=acf-field-group', 'Fewbricks', 'Fewbricks', 'activate_plugins',
            'fewbricksdev',
            function () {
                require_once(__DIR__ . '/../admin/views/dev.view.php');
            });

    }

}
