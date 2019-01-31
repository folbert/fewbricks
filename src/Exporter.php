<?php

namespace Fewbricks;

use Fewbricks\Helpers\Helper;

class Exporter
{

    /**
     * @param string $fieldGroupTitle
     * @param string $fieldGroupKey
     */
    public static function maybe_store_simple_field_group_data(string $fieldGroupTitle, string $fieldGroupKey)
    {

        if (Helper::pageIsFewbricksAdminPage()) {

            global $simpleFieldGroupsData;

            if (!is_array($simpleFieldGroupsData)) {
                $simpleFieldGroupsData = [];
            }

            $simpleFieldGroupsData[$fieldGroupKey] = $fieldGroupTitle;

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
                                self::getAutoWritePhpCodeFile()) . '</p>';
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
            $strReplace  = [
                "  "         => "\t",
                "'!!__(!!\'" => "__('",
                "!!\', !!\'" => "', '",
                "!!\')!!'"   => "')",
                "array ("    => "array(",
            ];
            $pregReplace = [
                '/([\t\r\n]+?)array/' => 'array',
                '/[0-9]+ => array/'   => 'array',
            ];

            // Loop the keys the caller has requested
            foreach ($fieldGroupKeys AS $fieldGroupKey) {

                if (isset($storedSettings[$fieldGroupKey])) {

                    $settingsCode = var_export($storedSettings[$fieldGroupKey], true);

                    // From ACF
                    $settingsCode = str_replace(array_keys($strReplace), array_values($strReplace), $settingsCode);

                    // From ACF
                    $settingsCode = preg_replace(array_keys($pregReplace), array_values($pregReplace), $settingsCode);

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

        return apply_filters('fewbricks/exporter/display_php_file_written_message', '__return_true');

    }

    /**
     *
     */
    public static function maybeExportJson()
    {

        $data = [];

        if (Exporter::exportToJsonTriggered()) {

            $fieldGroups = Exporter::getStoredFieldGroupsAcfSettings();

            if (!empty($fieldGroups)) {

                // construct JSON
                foreach ($fieldGroups as $fieldGroup) {

                    // prepare for export
                    $fieldGroup = acf_prepare_field_group_for_export($fieldGroup);

                    // add to json array
                    $data[] = $fieldGroup;

                }

                $fileName = 'fewbricks-acf-export-' . date('Y-m-d') . '.json';
                header("Content-Description: File Transfer");
                header("Content-Disposition: attachment; filename={$fileName}");
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

        return Helper::pageIsFewbricksAdminPage()
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
     * @param array $fieldGroupAcfSettings
     */
    public static function maybe_store_field_group_acf_settings(array $fieldGroupAcfSettings)
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

        return Helper::pageIsFewbricksAdminPage()
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

        return apply_filters('fewbricks/exporter/auto_write_php_code_file', false);

    }

    /**
     * @param array $fieldGroupAcfSettings
     */
    public static function storeFieldGroupAcfSettings(array $fieldGroupAcfSettings)
    {

        global $fieldGroupsAcfSettings;

        if (!is_array($fieldGroupsAcfSettings)) {
            $fieldGroupsAcfSettings = [];
        }

        $fieldGroupsAcfSettings[$fieldGroupAcfSettings['key']] = $fieldGroupAcfSettings;

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

}
