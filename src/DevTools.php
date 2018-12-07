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
    private const SETTINGS_NAME_FOR_DISPLAYING_ACF_ARRAY = 'fewbricks__display_in_dev_tools';

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
     *
     */
    public static function run($start_height)
    {

        self::setStartHeight($start_height);

        self::injectJs();
        add_action('admin_enqueue_scripts', [self::class, 'enqueue_assets']);
        add_action('admin_footer', [self::class, 'display']);

    }

    /**
     * @param $start_height
     */
    private static function setStartHeight($start_height)
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
    private static function injectJs()
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

        wp_enqueue_script('fewbricks-dev-tools', Helper::getFewbricksAssetsBaseUri() . '/scripts/dev-tools.js',
            [], Helper::getVersionOrTimestamp(), true);

        wp_enqueue_style('fewbricks-dev-tools', Helper::getFewbricksAssetsBaseUri() . '/styles/dev-tools.css',
            [], Helper::getVersionOrTimestamp(), false);

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
    public static function maybeStoreAcfSettingsArrayForDevDisplay(array $acf_settings_array)
    {

        if (self::isActivated()) {

            $settings_key = $acf_settings_array['key'];

            if (
                (
                    isset($acf_settings_array[self::SETTINGS_NAME_FOR_DISPLAYING_ACF_ARRAY]) &&
                    $acf_settings_array[self::SETTINGS_NAME_FOR_DISPLAYING_ACF_ARRAY] === true
                ) ||
                (
                    (false !== ($filter_value = self::getKeysToDisplaySettingsFor())) &&
                    (
                        $filter_value === true || // Not being false does not mean that it is true in this case
                        ($filter_value === $settings_key) ||
                        (is_array($filter_value) && in_array($settings_key, $filter_value))
                    )
                )
            ) {

                self::$acf_settings_arrays[$settings_key] = $acf_settings_array;

            } else if (isset($acf_settings_array['fields']) && is_array($acf_settings_array['fields'])) {

                foreach ($acf_settings_array['fields'] AS $sub_field) {

                    self::maybeStoreAcfSettingsArrayForDevDisplay($sub_field);

                }

            }

        }

    }

    /**
     * @return string
     */
    public static function getFilterString()
    {

        $filter_value = self::getKeysToDisplaySettingsFor();

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
    public static function getAcfSettingsArrays()
    {

        return self::$acf_settings_arrays;

    }

    /**
     *
     */
    public static function startExecutionTimer()
    {
        self::$execution_timer_start = microtime(true);
    }

    /**
     *
     */
    public static function endExecutionTimer()
    {
        self::$execution_timer_end = microtime(true);
    }

    /**
     * @return int
     */
    public static function getExecutionTime()
    {

        return round(self::$execution_timer_end - self::$execution_timer_start, 4);

    }

    /**
     * @return mixed|void
     */
    public static function isActivated()
    {

        return self::getDisplayFilterValue() !== false;

    }

    /**
     * @return mixed|void
     */
    public static function getDisplayFilterValue()
    {

        return apply_filters('fewbricks/dev_tools/display', false);

    }

    /**
     * @return mixed|void
     */
    public static function getKeysToDisplaySettingsFor()
    {

        return apply_filters('fewbricks/dev_tools/acf_arrays/keys', false);

    }

    /**
     * @return string
     */
    public static function getSettingsNameForDisplayingAcfArray()
    {

        return self::SETTINGS_NAME_FOR_DISPLAYING_ACF_ARRAY;

    }

    /**
     * @param $acf_settings_array
     * @return string
     */
    public static function getTitleFromAcfArray(array $acf_settings_array)
    {

        $title = '<i>unknown title</i>';

        $possible_keys = ['title', 'label'];

        foreach($possible_keys AS $possible_key) {

            if(isset($acf_settings_array[$possible_key])) {

                $title = $acf_settings_array[$possible_key];
                break;

            }

        }

        return $title;

    }

}
