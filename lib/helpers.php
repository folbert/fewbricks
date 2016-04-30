<?php

namespace fewbricks\helpers;

/**
 * Get the name of the class of an object without namspaces.
 * @param $object
 * @return mixed
 */
function get_real_class_name($object)
{

    $classname = get_class($object);

    if (preg_match('@\\\\([\w]+)$@', $classname, $matches)) {
        $classname = $matches[1];
    }

    return $classname;

}

/**
 * @return bool
 */
function is_fewbricks_in_developer_mode()
{

    return defined('FEWBRICKS_DEV_MODE') && FEWBRICKS_DEV_MODE === true;

}

/**
 * @return bool
 */
function use_acf_json()
{
    return defined('FEWBRICKS_USE_ACF_JSON') && FEWBRICKS_USE_ACF_JSON === true;

}

/**
 * @return mixed
 */
function acf_exists()
{
    return class_exists('acf');
}

/**
 * 
 */
function hide_acf_info()
{

    $dev_mode = is_fewbricks_in_developer_mode();

    return  !$dev_mode ||
        (defined('FEWBRICKS_HIDE_ACF_INFO') && FEWBRICKS_HIDE_ACF_INFO === true);
    
}