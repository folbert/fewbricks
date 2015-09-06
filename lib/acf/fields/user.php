<?php

namespace fewbricks\acf\fields;

/**
 * Class user
 * @package fewbricks\acf
 */
class user extends field
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
            'type' => 'user',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'role' => '',
            'allow_null' => 0,
            'multiple' => 0,
        ];

        parent::__construct($label, $name, $key, $base_settings);

    }

}