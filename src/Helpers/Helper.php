<?php

namespace Fewbricks\Helpers;

use Fewbricks\AcfFieldSnitch\AcfFieldSnitch;
use Fewbricks\DevTools;

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

        if (Filters::fieldSnitchIsEnabled()) {

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
    public static function getFieldByOriginalKeyFromAcfArray(string $key, array $acf_array)
    {

        $found_field = false;

        foreach ($acf_array AS $acf_array_key => $field_settings) {

            if ($field_settings['fewbricks__original_key'] == $key) {

                $found_field = $field_settings;

            }

            if ($found_field === false) {

                if (isset($field_settings['sub_fields']) && is_array($field_settings['sub_fields'])) {

                    $found_field = self::getFieldByOriginalKeyFromAcfArray($key, $field_settings['sub_fields']);

                } else if (isset($field_settings['layouts']) && is_array($field_settings['layouts'])) {

                    $found_field = self::getFieldByOriginalKeyFromAcfArray($key, $field_settings['layouts']);

                }

            }

        }

        return $found_field;

    }

    /**
     * @param $fields
     */
    public static function validateFieldNames($fields)
    {

        foreach ($fields AS $field) {

            if (strlen($field['name']) > 255) {

                wp_die('Fewbricks found a field whose field name exceeds 255 characters which will render the field useless. This is due to restrictions in the database scheme created by WordPress where a meta_key value in the _postmeta table can be no longer than 255 characters.');

            }

            if (isset($field['sub_fields']) && !empty($field['sub_fields'])) {
                self::validateFieldNames($field['sub_fields']);
            } elseif (isset($field['layouts']) && !empty($field['layouts'])) {
                self::validateFieldNames($field['layouts']);
            }

        }

    }

    /**
     * Keys only need to be validated against keys in the same collection since fields in a collection
     * always gets its key prefix from the field group.
     * @param array $fields
     * @param bool $die_on_invalid
     * @return bool
     */
    public static function validateUniqueKeys(array $fields, $die_on_invalid = true)
    {

        $flattened_acf_array = self::getFlattenedAcfArray($fields);

        $non_unique_key = self::getNonUniqueKey($flattened_acf_array);

        if ($non_unique_key !== false && $die_on_invalid) {

            $first_non_unique = false;
            $second_non_unique = false;
            foreach ($flattened_acf_array AS $field) {

                if ($field['key'] === $non_unique_key) {

                    if ($first_non_unique == false) {

                        $first_non_unique = $field;

                    } else {

                        $second_non_unique = $field;
                        break;

                    }

                }

            }

            $message = '';

            $message .= 'Error when attempting to register an item with the key "' . $second_non_unique . '"';

            if ($non_unique_field !== false) {
                $message .= ' and label "' . $second_non_unique['label'] . '"';
                $message .= ' and name "' . $second_non_unique['name'] . '"';
            }

            $message .= '. ';

            $message .= 'The key is already in use';

            if ($first_non_unique !== false) {

                $message .= ' by an item labeled "' . $first_non_unique['label'] . '"';
                $message .= ' and named "' . $first_non_unique['name'] . '"';

            }

            $message .= '.';

            $message
                .= '<br><br>Pro-tip: create your keys manually by using the current date and time . So if you
    are creating a field at 15:00 on December 24 2019, the key might be "1912241500a". Note the addition of an extra
    character to ensure that ACF can use the key but also to make sure that if you create another key within the same
    minute, you can simply append some other "random" letter to that key like "1912241500x"';

            wp_die($message);

        }

        return ($non_unique_key === false);

    }

    /**
     * @param array $fields Assumes a flat array.
     * @return bool|string True if all keys are unique, a string with the first duplicate key found
     * if all keys are not unique.
     */
    private static function getNonUniqueKey(array $fields)
    {

        $non_unique_key = false;
        $keys = [];

        foreach ($fields AS $field) {

            $field_key = $field['key'];

            if (isset($keys[$field_key])) {

                $non_unique_key = $field_key;
                break;

            }

            $keys[$field['key']] = 1;

        }

        return $non_unique_key;

    }

    /**
     * @param $acf_array_fields
     * @return array
     */
    public static function getFlattenedAcfArray($acf_array_fields)
    {

        $flattened = [];

        foreach ($acf_array_fields AS $field) {

            $flattened[] = $field;

            if (false !== ($child_fields = self::getChildFieldsArray($field))) {
                $flattened = array_merge($flattened, self::getFlattenedAcfArray($child_fields['fields']));
            }

        }

        return $flattened;


    }

    /**
     * @param $field_array
     * @return array|bool
     */
    public static function getChildFieldsArray($field_array)
    {

        $array = false;

        if (isset($field_array['sub_fields']) && !empty($field_array['sub_fields'])) {

            $array = [
                'name' => 'sub_fields',
                'fields' => $field_array['sub_fields'],
            ];

        } elseif (isset($field_array['layouts']) && !empty($field_array['layouts'])) {

            $array = [
                'name' => 'layouts',
                'fields' => $field_array['layouts'],
            ];

        }

        return $array;

    }

    /**
     * @param $path
     * @return string
     */
    public static function getDocumentationUrl($path = '') {

        return 'https://fewbricks2.folbert.com/' . $path;

    }

}
