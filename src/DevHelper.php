<?php

namespace Fewbricks;

class DevHelper
{

    private const GLOBALS_KEY_ACF_KEYS = 'fewbricks_dev_info_acf_array_keys';

    /**
     *
     */
    public static function run()
    {

        add_action('admin_enqueue_scripts', [self::class, 'enqueue_assets']);
        add_action('admin_footer', [self::class, 'display']);

    }

    /**
     *
     */
    public static function enqueue_assets()
    {

        wp_enqueue_script('fewbricks-dev-helper', Helper::getFewbricksAssetsBaseUri() . '/scripts/dev-helper.js',
            [], Helper::getVersionOrTimestamp(), true);

        wp_enqueue_style('fewbricks-dev-helper', Helper::getFewbricksAssetsBaseUri() . '/styles/dev-helper.css',
            [], Helper::getVersionOrTimestamp(), false);

    }

    /**
     *
     */
    public static function display()
    {

        $html = '<div id="fewbricks-dev-info">';
        $html .= '<div>';
        $html .= '<h1 class="fewbricks-dev-info__title">Fewbricks Dev Helper</h1>';

        $html .= '<h2 class="fewbricks-dev-info__section-title">Data sent to ACF</h2>';
        $html .= '<p class="fewbricks-dev-info__filter-value">Using the filter "fewbricks/fewbricks/dev_info/keys", you asked DevHelper to display data for:<br>';
        $html .= self::getFilterString() . '</p>';

        if (isset($GLOBALS[self::GLOBALS_KEY_ACF_KEYS]) && is_array($GLOBALS[self::GLOBALS_KEY_ACF_KEYS])) {

            foreach ($GLOBALS[self::GLOBALS_KEY_ACF_KEYS] AS $acf_array_to_display) {

                $html .= '<h3 class="fewbricks-dev-info__section-sub-title">' . $acf_array_to_display['title'] . '</h3>';

                ob_start();

                if (function_exists('dump')) {
                    dump($acf_array_to_display);
                } else {
                    echo '<pre>';
                    var_dump();
                    echo '</pre>';
                }

                $html .= ob_get_clean();

            }

        }

        $html .= '<button id="fewbricks-dev-info__full-toggler" ';
        $html .= 'data-expand-text="Expand" data-contract-text="Contract">Expand</button>';
        $html .= '</div>';
        $html .= '</div>';
        echo $html;

    }

    /**
     *
     */
    public static function maybeStoreAcfSettingsArrayForDevDisplay($acf_settings_array)
    {

        $filter_value = apply_filters('fewbricks/dev_info/keys', false);
        $settings_key = $acf_settings_array['key'];

        if (
            ($filter_value !== false) &&
            (
                $filter_value === true ||
                ($filter_value === $settings_key) ||
                (is_array($filter_value) && in_array($settings_key, $filter_value))
            )
        ) {

            if (!isset($GLOBALS[self::GLOBALS_KEY_ACF_KEYS])) {
                $GLOBALS[self::GLOBALS_KEY_ACF_KEYS] = [];
            }

            $GLOBALS[self::GLOBALS_KEY_ACF_KEYS][$settings_key] = $acf_settings_array;

        }

    }

    /**
     * @return int
     */
    private static function getNrOfItemsToDisplay()
    {

        $nr_of_items = 0;

        if (isset($GLOBALS[self::GLOBALS_KEY_ACF_KEYS])) {

            $nr_of_items = count($GLOBALS[self::GLOBALS_KEY_ACF_KEYS]);

        }

        return $nr_of_items;

    }

    /**
     * @return string
     */
    private static function getFilterString()
    {

        $filter_value = apply_filters('fewbricks/dev_info/keys', false);

        if (is_array($filter_value)) {
            $string = '[' . implode(', ', $filter_value) . ']';
        } elseif ($filter_value === true) {
            $string = 'all field groups (using "true")';
        } elseif ($filter_value === false) {
            $string = 'nothing (using "false")';
        } else {
            $string = (string)$filter_value;
        }

        return $string;

    }

}
