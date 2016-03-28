<?php

namespace fewbricks\acf\fields;

/**
 * Class hidden
 * @package fewbricks\acf\fields
 */
class hidden extends field
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
            'type' => 'hidden',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            'return_default_value' => 'yes'
        ];

        parent::__construct($label, $name, $key, $base_settings, $custom_settings);

    }

}