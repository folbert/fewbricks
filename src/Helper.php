<?php

namespace Fewbricks;

use Fewbricks\AcfFieldSnitch\AcfFieldSnitch;

class Helper
{

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
    public static function environmentIsFewbricksDev()
    {

        return defined('FEWBRICKS_DEV') && FEWBRICKS_DEV == 'true';

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
     * @return mixed|void
     */
    public static function fewbricksIsInDebugMode()
    {

        return apply_filters('fewbricks/debug_mode', false);

    }

    /**
     * @return mixed|void
     */
    public static function getVersion()
    {

        return get_option('fewbricks-version', -1);

    }


    /**
     * Returns a timestamp if we are in dev environment. Use for example when developing css and js.
     *
     * @return int
     */
    public static function getVersionOrTimestamp()
    {

        $outcome = time();

        if(!self::environmentIsFewbricksDev()) {
            $outcome = self::getVersion();
        }

        return $outcome;


    }

    /**
     *
     */
    public static function initDebug()
    {

        self::initFieldSnitch();

    }

    /**
     *
     */
    public static function initFieldSnitch()
    {

        if (apply_filters('fewbricks/activate_field_snitch', false)) {

            AcfFieldSnitch::init();

        }

    }

    /**
     * @return string
     */
    public static function getProjectInitFilePath()
    {

        return self::getProjectFilesBasePath() . '/' . self::getProjectInitFileName();

    }

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
    public static function getProjectInitFileName()
    {

        return apply_filters(
            'fewbricks/project_init_file_name',
            'fewbricks-init.php'
        );

    }

    /**
     * @return string
     */
    public static function getDefaultProjectFilesBasePath()
    {

        return __DIR__ . '/../fewbricks-demo';

    }

    /**
     * @return bool
     */
    public static function projectBasePathExists()
    {

        return file_exists(Helper::getProjectFilesBasePath());

    }

    /**
     * @return bool
     */
    public static function projectInitFileExists()
    {

        return file_exists(self::getProjectFilesBasePath() . '/' . self::getProjectInitFileName());

    }

    /**
     * @return bool
     */
    public static function projectBasePathIsDefault()
    {

        return self::getProjectFilesBasePath() === self::getDefaultProjectFilesBasePath();

    }

    /**
     * @param $fieldGroupTitle
     * @param $fieldGroupId
     */
    public static function maybeStoreSimpleFieldGroupData($fieldGroupTitle, $fieldGroupId)
    {

        if (self::pageIsFewbricksAdminPage()) {

            $fieldGroupsData = self::getStoredSimpleFieldGroupData();

            $fieldGroupsData[$fieldGroupId] = $fieldGroupTitle;

            update_option('fewbricks_field_groups', $fieldGroupsData);

        }

    }

    /**
     * @return bool
     */
    public static function pageIsFewbricksAdminPage()
    {

        $outcome = false;

        if (is_admin()
            && isset($_GET['post_type'])
            && isset($_GET['page'])
            && $_GET['post_type'] === 'acf-field-group'
            && $_GET['page'] === 'fewbricksdev'
        ) {

            $outcome = true;

        }

        return $outcome;

    }

    /**
     * @return mixed|void
     */
    public static function getStoredSimpleFieldGroupData()
    {

        return get_option('fewbricks_field_groups', []);

    }

}
