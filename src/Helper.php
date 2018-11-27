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

        dump($var);die();

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
     * @return mixed|void
     */
    public static function getBrickLayoutsBasePath()
    {

        return apply_filters('fewbricks/bricks/layouts_base_path', false);

    }

    /**
     * @param $brick_object
     *
     * @return mixed
     */
    public static function getBrickTemplateFileName($brick_object)
    {

        $namespaced_pieces = explode('\\', get_class($brick_object));
        $class_name        = array_pop($namespaced_pieces);

        // Turn CamelCaseFileNames to dashed-versions. (ClassName -> class-name)
        $dashed_class_name = preg_replace('/([A-Z]+)/', "-$1", lcfirst($class_name));

        return apply_filters('fewbricks/bricks/template_file_name', strtolower($dashed_class_name) . '.view.php',
            $brick_object);

    }

    /**
     * @param object $brick_object
     *
     * @return mixed|void
     */
    public static function getBrickTemplatesBasePath($brick_object)
    {

        return apply_filters('fewbricks/bricks/templates_base_path', false, $brick_object);

    }

    /**
     * @param string $original_key
     * @param array  $acf_array_items
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
     * If $key does not exist in $array, $default_value will be returned. Otherwise the value of $array[$key] will be returned
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

        if(DevTools::isActivated()) {
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

    public static function getFewbricksInstallPath()
    {

        //return __FILE__

    }

    /**
     * @return string
     */
    public static function getFewbricksAssetsBaseUri()
    {

        return plugins_url('fewbricks') . '/assets';

    }

}
