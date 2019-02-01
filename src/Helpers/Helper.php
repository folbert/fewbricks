<?php

namespace Fewbricks\Helpers;

use Fewbricks\AcfFieldSnitch;
use Fewbricks\DevTools;

/**
 * Class Helper
 *
 * @package Fewbricks
 */
class Helper
{

    const DOCUMENTATION_BASE_URL = 'https://fewbricks2.folbert.com/';

    /**
     * @return bool
     */
    public static function acf_is_activated()
    {

        return class_exists('acf');

    }

    /** @noinspection PhpMethodNamingConventionInspection */
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
    public static function fewbricks_hidden_is_activated()
    {

        // We must include this file here since we are calling is_plugin_active in an unusual place.
        include_once(ABSPATH . 'wp-admin/includes/plugin.php');

        return is_plugin_active('acf-fewbricks-hidden/acf-fewbricks-hidden.php');

    }

    /**
     * @param string $originalKey
     * @param array $acfArrayItems
     *
     * @return bool|string
     */
    public static function get_new_key_by_original_key_in_acf_array(string $originalKey, array $acfArrayItems)
    {

        $outcome = false;

        foreach ($acfArrayItems AS $acfArrayItem) {

            if ($acfArrayItem['fewbricks__original_key'] === $originalKey) {

                $outcome = $acfArrayItem['key'];
                break;

            }

        }

        return $outcome;

    }

    /**
     * If $key does not exist in $array, $default_value will be returned. Otherwise the value of $array[$key] will be
     * returned
     *
     * @param array $array
     * @param string $key
     * @param mixed $defaultValue
     *
     * @return mixed
     */
    public static function get_value_from_array(array $array, string $key, $defaultValue)
    {

        $outcome = $defaultValue;

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
    public static function get_installed_version_or_timestamp()
    {

        $outcome = time();

        if (!self::environment_is_fewbricks_dev()) {
            $outcome = self::get_installed_version();
        }

        return $outcome;

    }

    /**
     * @return bool
     */
    public static function environment_is_fewbricks_dev()
    {

        return defined('FEWBRICKS_DEV') && FEWBRICKS_DEV == 'true';

    }

    /**
     * Use Fewbricks::get_version to get the version of the files.
     * @return int
     */
    public static function get_installed_version()
    {

        return get_option('fewbricks-version', 0);

    }

    /**
     *
     */
    public static function init_debug()
    {

        if (DevTools::is_activated()) {
            DevTools::run(DevTools::get_display_filter_value());
        }

        self::init_field_snitch();

    }

    /**
     *
     */
    public static function init_field_snitch()
    {

        if (Filters::field_snitch_is_enabled()) {

            AcfFieldSnitch::init();

        }

    }

    /**
     * @return bool
     */
    public static function page_is_fewbricks_admin_page()
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
    public static function get_fewbricks_install_uri()
    {

        return plugins_url('fewbricks');

    }

    /**
     * @return string
     */
    public static function get_fewbricks_assets_base_uri()
    {

        return plugins_url('fewbricks') . '/assets';

    }

    /**
     * Makes sure that passed string starts with "field_"
     * @param string $fieldKey
     * @return string
     */
    public static function get_valid_field_key(string $fieldKey)
    {

        // Lets make sure that the key is ok for ACF
        // https://www.advancedcustomfields.com/resources/register-fields-via-php/#field-settings
        if (substr($fieldKey, 0, 6) !== 'field_') {
            $fieldKey = 'field_' . $fieldKey;
        }

        return $fieldKey;

    }

    /**
     * Makes sure that passed string starts with "_group"
     * @param $fieldGroupKey
     * @return string
     */
    public static function get_valid_field_group_key(string $fieldGroupKey)
    {

        // Lets keep in order with how ACF gives keys to field groups and prepend with "group_"
        // https://www.advancedcustomfields.com/resources/register-fields-via-php/
        if (substr($fieldGroupKey, 0, 6) !== 'group_') {
            $fieldGroupKey = 'group_' . $fieldGroupKey;
        }

        return $fieldGroupKey;

    }

    /**
     * @param string $key
     * @param array $acfArray
     * @return bool
     */
    public static function get_field_by_original_key_from_acf_array(string $key, array $acfArray)
    {

        $foundField = false;

        foreach ($acfArray AS $acfArrayKey => $fieldSettings) {

            if ($fieldSettings['fewbricks__original_key'] == $key) {

                $foundField = $fieldSettings;

            }

            if ($foundField === false) {

                if (isset($fieldSettings['sub_fields']) && is_array($fieldSettings['sub_fields'])) {

                    $foundField = self::get_field_by_original_key_from_acf_array($key, $fieldSettings['sub_fields']);

                } else if (isset($fieldSettings['layouts']) && is_array($fieldSettings['layouts'])) {

                    $foundField = self::get_field_by_original_key_from_acf_array($key, $fieldSettings['layouts']);

                }

            }

        }

        return $foundField;

    }

    /**
     * @return string
     */
    public static function get_php_version()
    {

        return phpversion();

    }

    /**
     * @param $fields
     */
    public static function validate_field_names($fields)
    {

        foreach ($fields AS $field) {

            if (strlen($field['name']) > 255) {

                self::fewbricks_die('Fewbricks found a field whose field name exceeds 255 characters which will render the field useless. This is due to restrictions in the database scheme created by WordPress where a meta_key value in the _postmeta table can be no longer than 255 characters.');

            }

            if (isset($field['sub_fields']) && !empty($field['sub_fields'])) {
                self::validate_field_names($field['sub_fields']);
            } elseif (isset($field['layouts']) && !empty($field['layouts'])) {
                self::validate_field_names($field['layouts']);
            }

        }

    }

    /**
     * Keys only need to be validated against keys in the same collection since fields in a collection
     * always gets its key prefix from the field group.
     * @param array $fields
     * @param bool $dieOnInvalid
     * @return bool
     */
    public static function validate_unique_keys(array $fields, $dieOnInvalid = true)
    {

        $flattenedAcfArray = self::get_flattened_acf_array($fields);

        $nonUniqueKey = self::get_non_unique_key($flattenedAcfArray);

        if ($nonUniqueKey !== false && $dieOnInvalid) {

            $firstNonUnique = false;
            $secondNonUnique = false;
            foreach ($flattenedAcfArray AS $field) {

                if ($field['key'] === $nonUniqueKey) {

                    if ($firstNonUnique == false) {

                        $firstNonUnique = $field;

                    } else {

                        $secondNonUnique = $field;
                        break;

                    }

                }

            }

            $message = '';

            $message .= 'Error when attempting to register an item with the key "' . $secondNonUnique . '"';

            if ($secondNonUnique !== false) {
                $message .= ' and label "' . $secondNonUnique['label'] . '"';
                $message .= ' and name "' . $secondNonUnique['name'] . '"';
            }

            $message .= '. ';

            $message .= 'The key is already in use';

            if ($firstNonUnique !== false) {

                $message .= ' by an item labeled "' . $firstNonUnique['label'] . '"';
                $message .= ' and named "' . $firstNonUnique['name'] . '"';

            }

            $message .= '.';

            $message
                .= '<br><br>Pro-tip: create your keys manually by using the current date and time . So if you
    are creating a field at 15:00 on December 24 2019, the key might be "1912241500a". Note the addition of an extra
    character to ensure that ACF can use the key but also to make sure that if you create another key within the same
    minute, you can simply append some other "random" letter to that key like "1912241500x"';

            self::fewbricks_die($message);

        }

        return ($nonUniqueKey === false);

    }

    /**
     * @param array $fields Assumes a flat array.
     * @return bool|string True if all keys are unique, a string with the first duplicate key found
     * if all keys are not unique.
     */
    private static function get_non_unique_key(array $fields)
    {

        $nonUniqueKey = false;
        $keys = [];

        foreach ($fields AS $field) {

            $fieldKey = $field['key'];

            if (isset($keys[$fieldKey])) {

                $nonUniqueKey = $fieldKey;
                break;

            }

            $keys[$field['key']] = 1;

        }

        return $nonUniqueKey;

    }

    /**
     * @param array $acfArrayFields
     * @return array
     */
    public static function get_flattened_acf_array(array $acfArrayFields)
    {

        $flattened = [];

        foreach ($acfArrayFields AS $field) {

            $flattened[] = $field;

            if (false !== ($childFields = self::get_child_fields_array($field))) {
                $flattened = array_merge($flattened, self::get_flattened_acf_array($childFields['fields']));
            }

        }

        return $flattened;


    }

    /**
     * @param array $fieldArray
     * @return array|bool
     */
    public static function get_child_fields_array(array $fieldArray)
    {

        $array = false;

        if (isset($fieldArray['sub_fields']) && !empty($fieldArray['sub_fields'])) {

            $array = [
                'name' => 'sub_fields',
                'fields' => $fieldArray['sub_fields'],
            ];

        } elseif (isset($fieldArray['layouts']) && !empty($fieldArray['layouts'])) {

            $array = [
                'name' => 'layouts',
                'fields' => $fieldArray['layouts'],
            ];

        }

        return $array;

    }

    /**
     * @param $path
     * @return string
     */
    public static function get_documentation_url(string $path = '')
    {

        return self::DOCUMENTATION_BASE_URL . $path;

    }

    /**
     * @param $message
     * @param bool $testExceptionClass
     * @return mixed
     */
    public static function fewbricks_die($message, $testExceptionClass = false)
    {

        if (defined('FEWBRICKS_UNIT_TESTING') && FEWBRICKS_UNIT_TESTING === true) {

            if($testExceptionClass === false) {
                $testExceptionClass = \RuntimeException::class;
            }

            throw new $testExceptionClass($message);

        } else if (function_exists('wp_die')) {
            wp_die($message);
        } else {
            die($message);
        }

    }

}
