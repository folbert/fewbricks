<?php

namespace Fewbricks;

use Fewbricks\Helpers\Helper;

/**
 * Class DevTools
 * @package Fewbricks
 */
class DevTools
{

    /**
     *
     */
    const SETTINGS_NAME_FOR_DISPLAYING_ACF_ARRAY = 'fewbricks__display_in_dev_tools';

    /**
     * @var array
     */
    private static $acfSettingsArrays = [];

    /**
     * @var int
     */
    private static $executionTimerStart = 0;

    /**
     * @var int
     */
    private static $executionTimerEnd = 0;

    /**
     * @var
     */
    private static $startHeight;

    /**
     * @param mixed $startHeight
     */
    public static function run($startHeight)
    {

        self::set_start_height($startHeight);

        self::inject_js();
        add_action('admin_enqueue_scripts', [self::class, 'enqueue_assets']);
        add_action('admin_footer', [self::class, 'display']);

    }

    /**
     * @param $startHeight
     */
    private static function set_start_height($startHeight)
    {

        if (isset($_GET['fewbricks-dev-tools-takeover'])) {
            $startHeight = 100;
        } else if ($startHeight === true) {
            $startHeight = '"minimized"';
        }

        self::$startHeight = $startHeight;

    }

    /**
     *
     */
    private static function inject_js()
    {

        add_action('admin_head', function () {

            echo '<script>
              var fewbricksDevTools = {
                startHeight: ' . DevTools::$startHeight . '
              };
            </script>';

        });

    }

    /**
     *
     */
    public static function enqueue_assets()
    {

        wp_enqueue_script('fewbricks-dev-tools', Helper::get_fewbricks_assets_base_uri() . '/scripts/dev-tools.js',
            [], Helper::get_installed_version_or_timestamp(), true);

        wp_enqueue_style('fewbricks-dev-tools', Helper::get_fewbricks_assets_base_uri() . '/styles/dev-tools.css',
            [], Helper::get_installed_version_or_timestamp(), false);

    }

    /**
     *
     */
    public static function display()
    {

        ob_start();
        require_once __DIR__ . '/../views/dev-tools.view.php';
        echo ob_get_clean();

    }

    /**
     * @param array $acfSettingsArray
     */
    public static function maybe_store_acf_settings_array_for_dev_display(array $acfSettingsArray)
    {

        if (self::is_activated()) {

            $settingsKey = $acfSettingsArray['key'];

            if (
                (
                    isset($acfSettingsArray[self::SETTINGS_NAME_FOR_DISPLAYING_ACF_ARRAY]) &&
                    $acfSettingsArray[self::SETTINGS_NAME_FOR_DISPLAYING_ACF_ARRAY] === true
                ) ||
                (
                    (false !== ($filterValue = self::get_keys_to_display_settings_for())) &&
                    (
                        $filterValue === true || // Not being false does not mean that it is true in this case
                        ($filterValue === $settingsKey) ||
                        (is_array($filterValue) && in_array($settingsKey, $filterValue))
                    )
                )
            ) {

                self::$acfSettingsArrays[$settingsKey] = $acfSettingsArray;

            } else if (isset($acfSettingsArray['fields']) && is_array($acfSettingsArray['fields'])) {

                foreach ($acfSettingsArray['fields'] AS $subField) {

                    self::maybe_store_acf_settings_array_for_dev_display($subField);

                }

            }

        }

    }

    /**
     * @return string
     */
    public static function get_filter_string()
    {

        $filterValue = self::get_keys_to_display_settings_for();

        if (is_array($filterValue)) {
            $string = '[' . implode(', ', $filterValue) . ']';
        } elseif ($filterValue === true) {
            $string = 'all field groups (since you sent "true")';
        } elseif ($filterValue === false) {
            $string = '';
        } else {
            $string = '"' . (string)$filterValue . '"';
        }

        return $string;

    }

    /**
     * @return array
     */
    public static function get_acf_settings_arrays()
    {

        return self::$acfSettingsArrays;

    }

    /**
     *
     */
    public static function start_execution_timer()
    {
        self::$executionTimerStart = microtime(true);
    }

    /**
     *
     */
    public static function end_execution_timer()
    {
        self::$executionTimerEnd = microtime(true);
    }

    /**
     * @return int
     */
    public static function get_execution_time()
    {

        return round(self::$executionTimerEnd - self::$executionTimerStart, 4);

    }

    /**
     * @return mixed
     */
    public static function is_activated()
    {

        return self::get_display_filter_value() !== false;

    }

    /**
     * @return mixed
     */
    public static function get_display_filter_value()
    {

        return apply_filters('fewbricks/dev_tools/display', false);

    }

    /**
     * @return mixed
     */
    public static function get_keys_to_display_settings_for()
    {

        return apply_filters('fewbricks/dev_tools/acf_arrays/keys', false);

    }

    /**
     * @param $acfSettingsArray
     * @return string
     */
    public static function get_title_from_acf_array(array $acfSettingsArray)
    {

        $title = '<i>unknown title</i>';

        $possibleKeys = ['title', 'label'];

        foreach($possibleKeys AS $possibleKey) {

            if(isset($acfSettingsArray[$possibleKey])) {

                $title = $acfSettingsArray[$possibleKey];
                break;

            }

        }

        return $title;

    }

}
