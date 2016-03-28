<?php

namespace fewbricks\acf\fields;

/**
 * Class image
 * @package fewbricks\acf\fields
 */
class image extends field
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
            'type' => 'image',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
                'width' => '',
                'class' => '',
                'id' => '',
            ],
            'return_format' => 'id',
            'preview_size' => 'medium',
            'library' => 'all',
        ];

        parent::__construct($label, $name, $key, $base_settings, $custom_settings);

    }

}