<?php

namespace fewbricks\acf\fields;

/**
 * Class tab
 * @package fewbricks\acf
 */
class tab extends field
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
            'type' => 'tab',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'placement' => 'top',
        ];

        parent::__construct($label, $name, $key, $base_settings);

    }

}