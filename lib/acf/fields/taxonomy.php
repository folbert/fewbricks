<?php

namespace fewbricks\acf\fields;

/**
 * Class taxonomy
 * @package fewbricks\acf
 */
class taxonomy extends field
{

    /**
     * @param string $label
     * @param string $name
     * @param string $key
     * @param array $custom_settings
     */
    public function __construct($label, $name, $key)
    {

        $base_settings = [
            'prefix' => '',
            'type' => 'taxonomy',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'taxonomy' => '',
            'field_type' => 'select',
            'allow_null' => 0,
            'load_save_terms' => 0,
            'return_format' => 'object',
            'multiple' => 0,
        ];

        parent::__construct($label, $name, $key, $base_settings);

    }

}