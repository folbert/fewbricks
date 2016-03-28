<?php

namespace fewbricks\acf\fields;

/**
 * Class relationship
 * @package fewbricks\acf\fields
 */
class relationship extends field
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
            'type' => 'relationship',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'post_type' => array(),
            'taxonomy' => array(),
            'min' => 0,
            'max' => 0,
            'filters' => array(
                0 => 'search',
                1 => 'post_type',
                2 => 'taxonomy',
            ),
            'elements' => array(),
            'return_format' => 'object',
        ];

        parent::__construct($label, $name, $key, $base_settings, $custom_settings);

    }

}