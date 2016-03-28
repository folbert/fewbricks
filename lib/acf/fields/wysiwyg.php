<?php

namespace fewbricks\acf\fields;

/**
 * Class wysiwyg
 * @package fewbricks\acf\fields
 */
class wysiwyg extends field
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

        $base_settings = [
            'prefix' => '',
            'type' => 'wysiwyg',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
                'width' => '',
                'class' => '',
                'id' => '',
            ],
            'default_value' => '',
            'tabs' => 'all',
            'toolbar' => 'full',
            'media_upload' => 1,
        ];

        parent::__construct($label, $name, $key, $base_settings, $custom_settings);

    }

}