<?php

namespace fewbricks\acf\fields;

/**
 * Class message
 * @package fewbricks\acf
 */
class message extends field
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
            'type' => 'message',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'message' => '',
        ];

        parent::__construct($label, $name, $key, $base_settings, $custom_settings);

    }

}