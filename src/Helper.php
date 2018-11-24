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

        return class_exists('acf');

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

        return apply_filters('fewbricks/brick_layouts_base_path', false);

    }

    /**
     * @param $brick_object
     *
     * @return mixed
     */
    public static function getBrickTemplateFileName($brick_object)
    {

        $namespaced_pieces = explode('\\', get_class($brick_object));
        $class_name        = array_pop($namespaced_pieces);

        // Turn CamelCaseFileNames to dashed-versions. (ClassName -> class-name)
        $dashed_class_name = preg_replace('/([A-Z]+)/', "-$1", lcfirst($class_name));

        return apply_filters('fewbricks/brick_template_file_name', strtolower($dashed_class_name) . '.view.php',
            $brick_object);

    }

    /**
     * @param object $brick_object
     *
     * @return mixed|void
     */
    public static function getBrickTemplatesBasePath($brick_object)
    {

        return apply_filters('fewbricks/brick_templates_base_path', false, $brick_object);

    }

    /**
     * @param string $original_key
     * @param array  $acf_array_items
     *
     * @return bool|string
     */
    public static function getNewKeyByOriginalKeyInAcfArray($original_key, $acf_array_items)
    {

        $outcome = false;

        foreach ($acf_array_items AS $acf_array_item) {

            if ($acf_array_item['fewbricks__original_key'] === $original_key) {

                $outcome = $acf_array_item['key'];
                break;

            }

        }

        return $outcome;

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
     * If $key does not exist in $array, $default_value will be returned. Otherwise the value of $array[$key] will be returned
     *
     * @param $array
     * @param $key
     * @param $defaultValue
     *
     * @return mixed
     */
    public static function getValueFromArray($array, $key, $defaultValue)
    {

        $outcome = $defaultValue;

        if (isset($array[$key])) {
            $outcome = $array[$key];
        }

        return $outcome;

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

}
