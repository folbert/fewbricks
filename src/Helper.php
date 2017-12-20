<?php

namespace Fewbricks;

use Fewbricks\AcfFieldSnitch\AcfFieldSnitch;

/**
 * Class Helper
 *
 * @package Fewbricks
 */
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
     *
     */
    public static function cleanUpAfterAdminPage()
    {

        delete_transient('fewbricks_field_groups_simple_data');

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
     * @return boolean
     */
    public static function fewbricksIsInDebugMode()
    {

        return apply_filters('fewbricks/debug_mode', false);

    }

    /**
     * @param $fieldGroupKeys
     *
     * @return array
     */
    public static function getFieldGroupsPhpCodes($fieldGroupKeys)
    {

        $codes = [];

        $storedSettings = self::getStoredFieldGroupsAcfSettings();

        // Taken from class-acf-admin-tool-export.php
        $str_replace  = [
            "  "         => "\t",
            "'!!__(!!\'" => "__('",
            "!!\', !!\'" => "', '",
            "!!\')!!'"   => "')",
            "array ("    => "array(",
        ];
        $preg_replace = [
            '/([\t\r\n]+?)array/' => 'array',
            '/[0-9]+ => array/'   => 'array',
        ];

        // Loop the keys the caller has requested
        foreach ($fieldGroupKeys AS $fieldGroupKey) {

            if (isset($storedSettings[$fieldGroupKey])) {

                $settingsCode = var_export($storedSettings[$fieldGroupKey], true);

                // From ACF
                $settingsCode = str_replace(array_keys($str_replace), array_values($str_replace), $settingsCode);

                // From ACF
                $settingsCode = preg_replace(array_keys($preg_replace), array_values($preg_replace), $settingsCode);

                $settingsCode = esc_textarea($settingsCode);

                $code = "if( function_exists('acf_add_local_field_group') ) {\r\n";
                $code .= "  acf_add_local_field_group(\r\n";
                $code .= "\t" . $settingsCode;
                $code .= "  )\r\n";
                $code .= '}';

            } else {

                $code = 'Could not find the code for this field group.';

            }

            $codes[$fieldGroupKey] = [$storedSettings[$fieldGroupKey]['title'], $code];

        }

        return $codes;

    }

    /**
     * @return mixed
     */
    public static function getStoredFieldGroupsAcfSettings()
    {

        return get_transient('fewbricks_field_groups_acf_settings');

    }

    /**
     * Returns a timestamp if we are in dev environment. Use for example when developing css and js.
     *
     * @return int
     */
    public static function getVersionOrTimestamp()
    {

        $outcome = time();

        if (!self::environmentIsFewbricksDev()) {
            $outcome = self::getVersion();
        }

        return $outcome;


    }

    /**
     * @return bool
     */
    public static function environmentIsFewbricksDev()
    {

        return defined('FEWBRICKS_DEV') && FEWBRICKS_DEV == 'true';

    }

    /**
     * @return int
     */
    public static function getVersion()
    {

        return get_option('fewbricks-version', -1);

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

        $basePath = apply_filters('fewbricks/project_files_base_path', self::getDefaultProjectFilesBasePath());

        return $basePath;

    }

    /**
     * @return string
     */
    public static function getProjectInitFileName()
    {

        return apply_filters('fewbricks/project_init_file_name', 'fewbricks-init.php');

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
     * @param $fieldGroupAcfSettings
     */
    public static function maybeStoreFieldGroupAcfSettings($fieldGroupAcfSettings)
    {

        if (
            self::pageIsFewbricksAdminPage()
            && isset($_GET['fewbricks_field_to_php'])
            && in_array($fieldGroupAcfSettings['key'], $_GET['fewbricks_field_to_php'])
        ) {

            $settings = self::getStoredFieldGroupsAcfSettings();

            $settings[$fieldGroupAcfSettings['key']] = $fieldGroupAcfSettings;

            set_transient('fewbricks_field_groups_acf_settings', $settings);

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
     * @param $fieldGroupTitle
     * @param $fieldGroupId
     */
    public static function maybeStoreSimpleFieldGroupData($fieldGroupTitle, $fieldGroupId)
    {

        if (self::pageIsFewbricksAdminPage()) {

            $fieldGroupsData = self::getStoredSimpleFieldGroupData();

            $fieldGroupsData[$fieldGroupId] = $fieldGroupTitle;

            set_transient('fewbricks_field_groups_simple_data', $fieldGroupsData);

        }

    }

    /**
     * @return array
     */
    public static function getStoredSimpleFieldGroupData()
    {

        $data = get_transient('fewbricks_field_groups_simple_data');

        if ($data === false) {
            $data = [];
        }

        return $data;

    }

}
