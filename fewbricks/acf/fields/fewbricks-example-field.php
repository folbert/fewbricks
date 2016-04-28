<?php

/**
 * This is an example class to show how to make an ACF add on work with Fewbricks.
 * Lots of public add ons can be found here: https://wordpress.org/plugins/search.php?q=Advanced+Custom+Fields
 */

namespace fewbricks\acf\fields;

/**
 * Class fewbricks_example_field
 * @package fewbricks\acf\fields
 */
class fewbricks_example_field extends field
{

    /**
     * @param string $label The label that the field will get.
     * @param string $name The name that the field will get.
     * @param string $key The key that the field wil get. It is very important that this value is unique among
     * all the keys across the entire site.
     * @param array $custom_settings Any custom settings that you want to set. A setting must be implemented in the ACF
     * field class for it to have an effect. This array wil be merged with $base_settings in this class and then with
     * the default settings in the ACF field class.
     */
    public function __construct($label, $name, $key, $custom_settings = [])
    {

        /**
         * The only required item in this array is "type" whose value should be the same as the name of this class.
         * The other items (which differs for each field type) only exists here to make it easier for a developer
         * to check out the class and be remembered of which options a field type has.
         * The easiest way to get these items and values is by using the GUI for ACF
         * to create a field group with an instance of the field type without setting any values on it and then, under
         * Custom Fields - >Tools, generate export code for the field group. From the output of that, you can copy the
         * array and paste it here.
         * Make sure that you remove "key", "label" and "name" form that array.
         * The example array below is taken from [plugins]/fewbricks/lib/acf/fields/google-maps.php, but we have changed
         * the value of "type" to match that of this class.
         */
        $base_settings = [
            'type' => 'fewbricks_example_field',
            'prefix' => '',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'center_lat' => '',
            'center_lng' => '',
            'zoom' => '',
            'height' => '',
        ];

        // This call must be present
        parent::__construct($label, $name, $key, $base_settings, $custom_settings);

    }

}