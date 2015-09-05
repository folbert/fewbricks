<?php

namespace fewbricks\acf\fields;

/**
 * Class date_picker
 * @package fewbricks\acf
 */
class date_picker extends field
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
            'type' => 'date_picker',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
                'width' => '',
                'class' => '',
                'id' => '',
            ],
            'display_format' => 'F j, Y',
            'return_format' => 'Ymd',
            'first_day' => 1,
        ];

        parent::__construct($label, $name, $key, $base_settings);

    }

}