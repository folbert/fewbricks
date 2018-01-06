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
    public static function getBrickLayoutsBasePath()
    {

        return apply_filters('fewbricks/brick_layouts_base_path', self::getProjectFilesBasePath() . '/brick-layouts');

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
    public static function getDefaultProjectFilesBasePath()
    {

        return __DIR__ . '/../fewbricks-demo';

    }

    /**
     * @param $brickObject
     *
     * @return mixed
     */
    public static function getBrickTemplateFileName($brickObject)
    {

        $namespacedClassNamePieces = explode('\\', get_class($brickObject));
        $className = array_pop($namespacedClassNamePieces);

        $dashedClassName = preg_replace('/([A-Z]+)/', "-$1", lcfirst($className));

        return apply_filters(
            'fewbricks/brick_template_file_name',
            strtolower($dashedClassName) . '.view.php',
            $brickObject
        );

    }

    /**
     * @param object $brickObject
     *
     * @return mixed|void
     */
    public static function getBrickTemplatesBasePath($brickObject)
    {

        return apply_filters(
            'fewbricks/brick_templates_base_path',
            self::getProjectFilesBasePath() . '/brick-templates',
            $brickObject
        );

    }

    /**
     * @param string $originalKey
     * @param array  $acfArrayItems
     *
     * @return bool|string
     */
    public static function getNewKeyByOriginalKeyInAcfArray($originalKey, $acfArrayItems)
    {

        $outcome = false;

        foreach ($acfArrayItems AS $acfArrayItem) {

            if ($acfArrayItem['fewbricks_original_key'] === $originalKey) {

                $outcome = $acfArrayItem['key'];
                break;

            }

        }

        return $outcome;

    }

    /**
     * @return string
     */
    public static function getProjectInitFilePath()
    {

        return self::getProjectFilesBasePath() . '/' . self::getProjectInitFileName();

    }

    /**
     * @return string
     */
    public static function getProjectInitFileName()
    {

        return apply_filters('fewbricks/project_init_file_name', 'fewbricks-init.php');

    }

    /**
     * @return array
     */
    public static function getStoredSimpleFieldGroupData()
    {

        global $simpleFieldGroupsData;

        if (!is_array($simpleFieldGroupsData)) {
            $simpleFieldGroupsData = [];
        }

        return $simpleFieldGroupsData;

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

        if (apply_filters('fewbricks/show_fields_info', false)) {

            AcfFieldSnitch::init();

        }

    }

    /**
     *
     */
    public static function maybeExportJson()
    {

        $data = [];

        if (Helper::exportToJsonTriggered()) {

            $fieldGroups = Helper::getStoredFieldGroupsAcfSettings();

            if (!empty($fieldGroups)) {

                // construct JSON
                foreach ($fieldGroups as $fieldGroup) {

                    // prepare for export
                    $fieldGroup = acf_prepare_field_group_for_export($fieldGroup);

                    // add to json array
                    $data[] = $fieldGroup;

                }

                $file_name = 'fewbricks-acf-export-' . date('Y-m-d') . '.json';
                header("Content-Description: File Transfer");
                header("Content-Disposition: attachment; filename={$file_name}");
                header("Content-Type: application/json; charset=utf-8");

                echo acf_json_encode($data);
                die();

            }

        }

    }

    /**
     * @return bool
     */
    public static function exportToJsonTriggered()
    {

        return self::pageIsFewbricksAdminPage()
               && isset($_GET['action'])
               && $_GET['action'] === 'fewbricks_export_json'
               && wp_verify_nonce($_GET['_wpnonce'], 'fewbricks_export_d89dtygodl');

    }

    /**
     * @return mixed
     */
    public static function getStoredFieldGroupsAcfSettings()
    {

        global $fieldGroupsAcfSettings;

        return $fieldGroupsAcfSettings;

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
     * @param $fieldGroupAcfSettings
     */
    public static function maybeStoreFieldGroupAcfSettings($fieldGroupAcfSettings)
    {

        if (
            (
                (self::generatePhpCodeTriggered() || self::exportToJsonTriggered())
                && isset($_GET['fewbricks_selected_field_groups_for_export'])
                && is_array($_GET['fewbricks_selected_field_groups_for_export'])
                && in_array($fieldGroupAcfSettings['key'], $_GET['fewbricks_selected_field_groups_for_export'])
            )
            || self::getAutoWritePhpCodeFile() !== false
        ) {

            self::storeFieldGroupAcfSettings($fieldGroupAcfSettings);

        }

    }

    /**
     * @return bool
     */
    public static function generatePhpCodeTriggered()
    {

        return self::pageIsFewbricksAdminPage()
               && isset($_GET['action'])
               && $_GET['action'] === 'fewbricks_generate_php'
               && isset($_GET['fewbricks_selected_field_groups_for_export'])
               && is_array($_GET['fewbricks_selected_field_groups_for_export'])
               && wp_verify_nonce($_GET['_wpnonce'], 'fewbricks_export_d89dtygodl');

    }

    /**
     * @return string|boolean False if no file should be used.
     */
    public static function getAutoWritePhpCodeFile()
    {

        return apply_filters('fewbricks/auto_write_php_code_file', false);

    }

    /**
     * @param array $fieldGroupAcfSettings
     */
    public static function storeFieldGroupAcfSettings($fieldGroupAcfSettings)
    {

        global $fieldGroupsAcfSettings;

        if (!is_array($fieldGroupsAcfSettings)) {
            $fieldGroupsAcfSettings = [];
        }

        $fieldGroupsAcfSettings[$fieldGroupAcfSettings['key']] = $fieldGroupAcfSettings;

    }

    /**
     * @param $fieldGroupTitle
     * @param $fieldGroupId
     */
    public static function maybeStoreSimpleFieldGroupData($fieldGroupTitle, $fieldGroupId)
    {

        if (self::pageIsFewbricksAdminPage()) {

            global $simpleFieldGroupsData;

            if (!is_array($simpleFieldGroupsData)) {
                $simpleFieldGroupsData = [];
            }

            $simpleFieldGroupsData[$fieldGroupId] = $fieldGroupTitle;

        }

    }

    /**
     *
     */
    public static function maybeWriteToPhpCodeFile()
    {

        $codeToWrite = '';

        $targetFile = self::getAutoWritePhpCodeFile();

        if ($targetFile !== false) {

            $codes = self::getFieldGroupsPhpCodes();

            if (is_array($codes)) {

                foreach ($codes AS $code) {

                    $codeToWrite .= $code[1];

                }

            }

            if (!empty($codeToWrite)) {

                file_put_contents($targetFile, "<?php\r\r" . $codeToWrite);

                if (self::displayPhpFileWrittenMessage()) {

                    add_action('admin_notices', function () {

                        $message = '<div class="notice notice-info">';
                        $message .= '<p>' . sprintf(__('PHP code written to <code>%s</code>', 'fewbricks'),
                                Helper::getAutoWritePhpCodeFile()) . '</p>';
                        $message .= '</div>';

                        echo $message;

                    });

                }

            }

        }

    }

    /**
     * @param mixed|boolean $fieldGroupKeys An array with the keys of the field groups you want to get. Pass false to
     *                                      retrieve all stored field groups.
     *
     * @return array
     */
    public static function getFieldGroupsPhpCodes($fieldGroupKeys = false)
    {

        $codes = [];

        $storedSettings = self::getStoredFieldGroupsAcfSettings();

        if (!empty($storedSettings)) {

            if ($fieldGroupKeys === false) {
                $fieldGroupKeys = array_keys($storedSettings);
            }

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

                    $code = "//-------------\r";
                    $code .= "// Start of field group \"" . $storedSettings[$fieldGroupKey]['title'] . "\"\r";
                    $code .= "//-------------\r\r";

                    $code .= "if( function_exists('acf_add_local_field_group') ) {\r\n";
                    $code .= "  acf_add_local_field_group(\r\n";
                    $code .= "\t" . $settingsCode;
                    $code .= "  );\r\n";
                    $code .= '}';

                    $code .= "\r//-------------\r";
                    $code .= "// End of field group \"" . $storedSettings[$fieldGroupKey]['title'] . "\"\r";
                    $code .= "//-------------\r\r";

                } else {

                    $code = __('Could not find any code for this field group.', 'fewbricks');

                }

                $codes[$fieldGroupKey] = [$storedSettings[$fieldGroupKey]['title'], $code];

            }

        }

        return $codes;

    }

    /**
     * @return mixed
     */
    public static function displayPhpFileWrittenMessage()
    {

        return apply_filters('fewbricks/display_php_file_written_message', '__return_true');

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
    public static function projectBasePathIsDefault()
    {

        return self::getProjectFilesBasePath() === self::getDefaultProjectFilesBasePath();

    }

    /**
     * @return bool
     */
    public static function projectInitFileExists()
    {

        return file_exists(self::getProjectFilesBasePath() . '/' . self::getProjectInitFileName());

    }

}
