<?php

namespace Fewbricks;

use Fewbricks\Helpers\Helper;

class Exporter
{

    /**
     * @param $field_group_title
     * @param $field_group_id
     */
    public static function maybeStoreSimpleFieldGroupData($field_group_title, $field_group_id)
    {

        if (Helper::pageIsFewbricksAdminPage()) {

            global $simple_field_groups_data;

            if (!is_array($simple_field_groups_data)) {
                $simple_field_groups_data = [];
            }

            $simple_field_groups_data[$field_group_id] = $field_group_title;

        }

    }

    /**
     *
     */
    public static function maybeWriteToPhpCodeFile()
    {

        $code_to_write = '';

        $target_file = self::getAutoWritePhpCodeFile();

        if ($target_file !== false) {

            $codes = self::getFieldGroupsPhpCodes();

            if (is_array($codes)) {

                foreach ($codes AS $code) {

                    $code_to_write .= $code[1];

                }

            }

            if (!empty($code_to_write)) {

                file_put_contents($target_file, "<?php\r\r" . $code_to_write);

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
     * @param mixed|boolean $field_group_keys An array with the keys of the field groups you want to get. Pass false to
     *                                      retrieve all stored field groups.
     *
     * @return array
     */
    public static function getFieldGroupsPhpCodes($field_group_keys = false)
    {

        $codes = [];

        $stored_settings = self::getStoredFieldGroupsAcfSettings();

        if (!empty($stored_settings)) {

            if ($field_group_keys === false) {
                $field_group_keys = array_keys($stored_settings);
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
            foreach ($field_group_keys AS $field_group_key) {

                if (isset($stored_settings[$field_group_key])) {

                    $settings_code = var_export($stored_settings[$field_group_key], true);

                    // From ACF
                    $settings_code = str_replace(array_keys($str_replace), array_values($str_replace), $settings_code);

                    // From ACF
                    $settings_code = preg_replace(array_keys($preg_replace), array_values($preg_replace), $settings_code);

                    $code = "//-------------\r";
                    $code .= "// Start of field group \"" . $stored_settings[$field_group_key]['title'] . "\"\r";
                    $code .= "//-------------\r\r";

                    $code .= "if( function_exists('acf_add_local_field_group') ) {\r\n";
                    $code .= "  acf_add_local_field_group(\r\n";
                    $code .= "\t" . $settings_code;
                    $code .= "  );\r\n";
                    $code .= '}';

                    $code .= "\r//-------------\r";
                    $code .= "// End of field group \"" . $stored_settings[$field_group_key]['title'] . "\"\r";
                    $code .= "//-------------\r\r";

                } else {

                    $code = __('Could not find any code for this field group.', 'fewbricks');

                }

                $codes[$field_group_key] = [$stored_settings[$field_group_key]['title'], $code];

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

            $field_groups = Exporter::getStoredFieldGroupsAcfSettings();

            if (!empty($field_groups)) {

                // construct JSON
                foreach ($field_groups as $field_group) {

                    // prepare for export
                    $field_group = acf_prepare_field_group_for_export($field_group);

                    // add to json array
                    $data[] = $field_group;

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

        global $field_groups_acf_settings;

        return $field_groups_acf_settings;

    }

    /**
     * @param $field_group_acf_settings
     */
    public static function maybeStoreFieldGroupAcfSettings($field_group_acf_settings)
    {

        if (
            (
                (self::generatePhpCodeTriggered() || self::exportToJsonTriggered())
                && isset($_GET['fewbricks_selected_field_groups_for_export'])
                && is_array($_GET['fewbricks_selected_field_groups_for_export'])
                && in_array($field_group_acf_settings['key'], $_GET['fewbricks_selected_field_groups_for_export'])
            )
            || self::getAutoWritePhpCodeFile() !== false
        ) {

            self::storeFieldGroupAcfSettings($field_group_acf_settings);

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
     * @param array $field_group_acf_settings
     */
    public static function storeFieldGroupAcfSettings($field_group_acf_settings)
    {

        global $field_groups_acf_settings;

        if (!is_array($field_groups_acf_settings)) {
            $field_groups_acf_settings = [];
        }

        $field_groups_acf_settings[$field_group_acf_settings['key']] = $field_group_acf_settings;

    }

    /**
     * @return array
     */
    public static function getStoredSimpleFieldGroupData()
    {

        global $simple_field_groups_data;

        if (!is_array($simple_field_groups_data)) {
            $simple_field_groups_data = [];
        }

        return $simple_field_groups_data;

    }

}
