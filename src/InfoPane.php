<?php

namespace Fewbricks;

use Fewbricks\Helpers\Helper;

/**
 * Class InfoPane
 * @package Fewbricks
 */
class InfoPane
{

    /**
     *
     */
    const SETTINGS_NAME_FOR_DISPLAYING_ACF_ARRAY = 'fewbricks__display_in_info_pane';

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

        if (isset($_GET['fewbricks-info-pane-height'])) {
            $start_height = $_GET['fewbricks-info-pane-height'];
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
              var fewbricksInfoPane = {
                startHeight: ' . InfoPane::$start_height . '
              };
            </script>';

        });

    }

    /**
     *
     */
    public static function enqueue_assets()
    {

        wp_enqueue_script('fewbricks-info-pane', Helper::get_fewbricks_assets_base_uri() . '/scripts/info-pane.js',
            [], Helper::get_installed_version_or_timestamp(), true);

        wp_enqueue_style('fewbricks-info-pane', Helper::get_fewbricks_assets_base_uri() . '/styles/info-pane.css',
            [], Helper::get_installed_version_or_timestamp(), false);

    }

    /**
     *
     */
    public static function display()
    {

        ob_start();
        require_once __DIR__ . '/../views/info-pane.view.php';
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
                self::display_all_acf_arrays()
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

        return apply_filters('fewbricks/info_pane/display', false);

    }

    /**
     * @return bool
     */
    public static function display_all_acf_arrays()
    {

        return apply_filters('fewbricks/info_pane/acf_arrays/display_all', true);

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
