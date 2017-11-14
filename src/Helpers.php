<?php

namespace Fewbricks;

class Helpers {

    /**
     * @return string The base path to the project files.
     */
    public static function get_project_files_base_path()
    {

        return apply_filters(
            'fewbricks/project_files_base_path',
            get_stylesheet_directory() . '/fewbricks'
        );

    }

    /**
     * @return bool
     */
    public static function acf_is_activated()
    {

        // We must include this file here since we are calling is_plugin_active in an unusual place.
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        return is_plugin_active('advanced-custom-fields-pro/acf.php') || is_plugin_active('advanced-custom-fields/acf.php');

    }

    /**
     * @return bool
     */
    public static function project_base_path_exists()
    {

        return file_exists(Helpers::get_project_files_base_path());

    }

    /**
     *
     */
    public static function fewbricks_hidden_is_activated()
    {

        // We must include this file here since we are calling is_plugin_active in an unusual place.
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        return is_plugin_active('acf-fewbricks-hidden/acf-fewbricks-hidden.php');

    }

}
