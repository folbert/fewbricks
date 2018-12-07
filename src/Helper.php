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
     * @param $var
     */
    public static function dd($var)
    {

        dump($var);
        die();

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
     * @param string $original_key
     * @param array $acf_array_items
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
     * If $key does not exist in $array, $default_value will be returned. Otherwise the value of $array[$key] will be
     * returned
     *
     * @param $array
     * @param $key
     * @param $default_value
     *
     * @return mixed
     */
    public static function getValueFromArray($array, $key, $default_value)
    {

        $outcome = $default_value;

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
            $outcome = self::getInstalledVersion();
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
     * Use Fewbricks::getVersion to get the version of the files.
     * @return int
     */
    public static function getInstalledVersion()
    {

        return get_option('fewbricks-version', 0);

    }

    /**
     *
     */
    public static function initDebug()
    {

        if (DevTools::isActivated()) {
            DevTools::run(DevTools::getDisplayFilterValue());
        }

        self::initFieldSnitch();

    }

    /**
     *
     */
    public static function initFieldSnitch()
    {

        if (apply_filters('fewbricks/dev_tools/show_fields_info', false)) {

            AcfFieldSnitch::init();

        }

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
     * @return string
     */
    public static function getFewbricksInstallUri()
    {

        return plugins_url('fewbricks');

    }

    /**
     * @return string
     */
    public static function getFewbricksAssetsBaseUri()
    {

        return plugins_url('fewbricks') . '/assets';

    }

    /**
     * @param $field_key
     * @return string
     */
    public static function getValidFieldKey($field_key)
    {

        // Lets make sure that the key is ok for ACF
        // https://www.advancedcustomfields.com/resources/register-fields-via-php/#field-settings
        if (substr($field_key, 0, 6) !== 'field_') {
            $field_key = 'field_' . $field_key;
        }

        return $field_key;

    }

    /**
     * @param $field_group_key
     * @return string
     */
    public static function getValidFieldGroupKey($field_group_key)
    {

        // Lets keep in order with how ACF gives keys to field groups and prepend with "group_"
        // https://www.advancedcustomfields.com/resources/register-fields-via-php/
        if (substr($field_group_key, 0, 6) !== 'group_') {
            $field_group_key = 'group_' . $field_group_key;
        }

        return $field_group_key;

    }

    /**
     * @param string $key
     * @param array $acf_array
     * @return bool
     */
    public static function getFieldByOriginalKeyFromAcfArray(string $key, array $acf_array) {

        $found_field = false;

        foreach($acf_array AS $acf_array_key => $field_settings) {

            if($field_settings['fewbricks__original_key'] == $key) {

                $found_field = $field_settings;

            }

            if($found_field === false) {

                if(isset($field_settings['sub_fields']) && is_array($field_settings['sub_fields'])) {

                    $found_field = self::getFieldByOriginalKeyFromAcfArray($key, $field_settings['sub_fields']);

                } else if(isset($field_settings['layouts']) && is_array($field_settings['layouts'])) {

                    $found_field = self::getFieldByOriginalKeyFromAcfArray($key, $field_settings['layouts']);

                }

            }

        }

        return $found_field;

    }

}
