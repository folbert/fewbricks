<?php

namespace Fewbricks;

use Fewbricks\AcfFieldSnitch\AcfFieldSnitch;

class Helpers
{

    /**
     * @return string The base path to the project files.
     */
    public static function getProjectFilesBasePath()
    {

        $basePath = apply_filters(
            'fewbricks/project_files_base_path',
            self::getDefaultProjectFilesBasePath()
        );

        return $basePath;

    }

    /**
     * @return mixed|void
     */
    public static function getProjectInitFilePath()
    {

        return apply_filters(
            'fewbricks/project_init_file_path',
            self::getProjectFilesBasePath() . '/init.php'
        );

    }

    /**
     * @param bool $force Set to true to ignore the filter
     */
    public static function initDebug($force = false)
    {

        self::initFieldSnitch($force);

    }

    /**
     * @param bool $force Set to true to ignore the filter
     */
    public static function initFieldSnitch($force = false)
    {

        if ($force
            || apply_filters(
                'fewbricks/activate_field_snitch',
                false
            )
        ) {

            AcfFieldSnitch::init();

        }

    }

    /**
     * @return bool
     */
    public static function acfIsActivated()
    {

        // We must include this file here since we are calling is_plugin_active in an unusual place.
        include_once(ABSPATH . 'wp-admin/includes/plugin.php');

        return is_plugin_active('advanced-custom-fields-pro/acf.php')
               || is_plugin_active('advanced-custom-fields/acf.php');

    }

    /**
     * @return bool
     */
    public static function projectBasePathExists()
    {

        return file_exists(Helpers::getProjectFilesBasePath());

    }

    /**
     * @return bool
     */
    public static function projectInitFileExists()
    {

        return file_exists(self::getProjectInitFilePath());

    }

    /**
     * @return bool
     */
    public static function fewbricksHiddenIsActivated()
    {

        // We must include this file here since we are calling is_plugin_active in an unusual place.
        include_once(ABSPATH . 'wp-admin/includes/plugin.php');

        return is_plugin_active('acf-fewbricks-hidden/acf-fewbricks-hidden.php');

    }

    /**
     * @return string
     */
    public static function getDefaultProjectFilesBasePath()
    {

        return __DIR__ . '/../fewbricks/';

    }

    /**
     * @return bool
     */
    public static function projectBasePathIsDefault()
    {

        return self::getProjectFilesBasePath() === self::getDefaultProjectFilesBasePath();

    }

}
