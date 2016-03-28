<?php

namespace fewbricks\acf\fields;

/**
 * Class radio
 * @package fewbricks\acf\fields
 */
class radio extends field
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
            'type' => 'radio',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'choices' => [], // array ('yes' => 'Yes','no' => 'No')
            'other_choice' => 0,
            'save_other_choice' => 0,
            'default_value' => '', //'yes'
            'layout' => 'vertical',
        ];

        parent::__construct($label, $name, $key, $base_settings, $custom_settings);

    }

}