<?php

namespace fewbricks\acf\fields;

/**
 * Class color_picker
 * @package fewbricks\acf
 */
class color_picker extends field
{

    /**
     * @param string $label
     * @param string $name
     * @param string $key
     * @param array $custom_settings
     */
    public function __construct($label, $name, $key, $custom_settings = [])
    {

        $base_settings = [
            'prefix' => '',
            'type' => 'color_picker',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
        ];

        parent::__construct($label, $name, $key, $base_settings, $custom_settings);

    }

}