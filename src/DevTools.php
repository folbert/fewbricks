<?php

namespace Fewbricks;

/**
 * Class DevTools
 * @package Fewbricks
 */
class DevTools
{

    /**
     * @var array
     */
    private static $acf_settings_arrays = [];

    private static $execution_timer_start = 0;

    private static $execution_timer_end = 0;

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

        if($start_height === true) {
            $start_height = '"minimized"';
        }

        self::$start_height = $start_height;

    }

    /**
     *
     */
    private static function injectJs()
    {

        add_action('admin_head', function() {

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
     *
     */
    public static function maybeStoreAcfSettingsArrayForDevDisplay($acf_settings_array)
    {

        $filter_value = apply_filters('fewbricks/dev_tools/keys', false);
        $settings_key = $acf_settings_array['key'];

        if (
            ($filter_value !== false) &&
            (
                $filter_value === true ||
                ($filter_value === $settings_key) ||
                (is_array($filter_value) && in_array($settings_key, $filter_value))
            )
        ) {

            self::$acf_settings_arrays[$settings_key] = $acf_settings_array;

        }

    }

    /**
     * @return string
     */
    public static function getFilterString()
    {

        $filter_value = apply_filters('fewbricks/dev_tools/keys', false);

        if (is_array($filter_value)) {
            $string = '[' . implode(', ', $filter_value) . ']';
        } elseif ($filter_value === true) {
            $string = 'all field groups (using "true")';
        } elseif ($filter_value === false) {
            $string = 'nothing (using "false")';
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

}
