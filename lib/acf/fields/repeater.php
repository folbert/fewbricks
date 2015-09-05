<?php

namespace fewbricks\acf\fields;

/**
 * Class repeater
 * @package fewbricks\acf
 */
class repeater extends field
{

    /**
     * @param $key
     * @param $name
     * @param $label
     * @param array $settings
     */
    public function __construct($label, $name, $key)
    {

        $settings = [
            'prefix' => '',
            'type' => 'repeater',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
                'width' => '',
                'class' => '',
                'id' => '',
            ],
            'min' => '',
            'max' => '',
            'layout' => 'block',
            'button_label' => 'Add Row',
            'sub_fields' => []
        ];

        parent::__construct($label, $name, $key, $settings);

    }

    /**
     * @param \fewbricks\bricks\brick $brick
     * @return $this
     */
    public function add_brick($brick)
    {

        $brick_settings = $brick->get_settings($this);

        foreach ($brick_settings['fields'] AS $brick_field) {

            $this->settings['sub_fields'][] = $brick_field;

        }

        return $this;

    }

    /**
     * @param $field_object
     * @return $this
     */
    public function add_sub_field($field_object)
    {

        $this->settings['sub_fields'][] = $field_object->get_settings($this);

        return $this;

    }

}