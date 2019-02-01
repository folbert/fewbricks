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
    private static $acf_settings_arrays = [];

    /**
     * @var int
     */
    private static $execution_timer_start = 0;

    /**
     * @var int
     */
    private static $execution_timer_end = 0;

    /**
     * @var
     */
    private static $start_height;

    /**
     * @param mixed $start_height
     */
    public static function run($start_height)
    {

        self::set_start_height($start_height);

        self::inject_js();
        add_action('admin_enqueue_scripts', [self::class, 'enqueue_assets']);
        add_action('admin_footer', [self::class, 'display']);

    }

    /**
     * @param $start_height
     */
    private static function set_start_height($start_height)
    {

        if (isset($_GET['fewbricks-dev-tools-takeover'])) {
            $start_height = 100;
        } else if ($start_height === true) {
            $start_height = '"minimized"';
        }

        self::$start_height = $start_height;

    }

    /**
     *
     */
    private static function inject_js()
    {

        add_action('admin_head', function () {

            echo '<script>
              var fewbricksDevTools = {
                startHeight: ' . DevTools::$start_height . '
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
     * @param array $acf_settings_array
     */
    public static function maybe_store_acf_settings_array_for_dev_display(array $acf_settings_array)
    {

        if (self::is_activated()) {

            $settings_key = $acf_settings_array['key'];

            if (
                (
                    isset($acf_settings_array[self::SETTINGS_NAME_FOR_DISPLAYING_ACF_ARRAY]) &&
                    $acf_settings_array[self::SETTINGS_NAME_FOR_DISPLAYING_ACF_ARRAY] === true
                ) ||
                (
                    (false !== ($filter_value = self::get_keys_to_display_settings_for())) &&
                    (
                        $filter_value === true || // Not being false does not mean that it is true in this case
                        ($filter_value === $settings_key) ||
                        (is_array($filter_value) && in_array($settings_key, $filter_value))
                    )
                )
            ) {

                self::$acf_settings_arrays[$settings_key] = $acf_settings_array;

            } else if (isset($acf_settings_array['fields']) && is_array($acf_settings_array['fields'])) {

                foreach ($acf_settings_array['fields'] AS $subField) {

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

        $filter_value = self::get_keys_to_display_settings_for();

        if (is_array($filter_value)) {

            $string = '[' . implode(', ', $filter_value) . ']';

        } elseif ($filter_value === true) {

            $string = 'all field groups (since you sent "true")';

        } elseif ($filter_value === false) {

            $string = '';

        } else {

            $string = '"' . (string)$filter_value . '"';

        }

        return $string;

    }

    /**
     * @return array
     */
    public static function get_acf_settings_arrays()
    {

        return self::$acf_settings_arrays;

    }

    /**
     *
     */
    public static function start_execution_timer()
    {
        self::$execution_timer_start = microtime(true);
    }

    /**
     *
     */
    public static function end_execution_timer()
    {
        self::$execution_timer_end = microtime(true);
    }

    /**
     * @return int
     */
    public static function get_execution_time()
    {

        return round(self::$execution_timer_end - self::$execution_timer_start, 4);

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
