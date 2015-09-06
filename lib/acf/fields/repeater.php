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
     * @param $arg
     */
    public function add_field($arg)
    {

        wp_die('Message from Fewbricks: In order to be consistent with ACFs terminology, there is no function <code>add_field</code> for repeaters. Use <code>add_sub_field</code> instead.');

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
     * @param repeater $repeater
     * @return repeater $this
     */
    public function add_repeater($repeater)
    {

        $this->settings['sub_fields'][] = $repeater->get_settings($this);

        return $this;

    }

    /**
     * @param flexible_content $flexible_content
     * @return $this
     */
    public function add_flexible_content($flexible_content)
    {

        $this->add_sub_field($flexible_content);

        return $this;

    }


}