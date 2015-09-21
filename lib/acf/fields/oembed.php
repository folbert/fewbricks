<?php

namespace fewbricks\acf\fields;

/**
 * Class oembed
 * @package fewbricks\acf
 */
class oembed extends field
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
            'type' => 'oembed',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'width' => '',
            'height' => '',
        ];

        parent::__construct($label, $name, $key, $base_settings, $custom_settings);

    }

}