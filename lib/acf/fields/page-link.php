<?php

namespace fewbricks\acf\fields;

/**
 * Class page_link
 * @package fewbricks\acf
 */
class page_link extends field
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
            'type' => 'page_link',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
                'width' => '',
                'class' => '',
                'id' => '',
            ],
            'post_type' => '',
            'taxonomy' => '',
            'allow_null' => 1,
            'multiple' => 0,
        ];

        parent::__construct($label, $name, $key, $base_settings);

    }

}