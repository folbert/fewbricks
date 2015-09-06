<?php

namespace fewbricks\acf\fields;

/**
 * Class textarea
 * @package fewbricks\acf
 */
class textarea extends field
{

    /**
     * @param string $label
     * @param string $name
     * @param string $key
     */
    public function __construct($label, $name, $key)
    {

        $base_settings = [
            'prefix' => '',
            'type' => 'textarea',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
                'width' => '',
                'class' => '',
                'id' => '',
            ],
            'default_value' => '',
            'placeholder' => '',
            'maxlength' => '',
            'rows' => '',
            'new_lines' => 'wpautop',
            'readonly' => 0,
            'disabled' => 0,
        ];

        parent::__construct($label, $name, $key, $base_settings);

    }

}