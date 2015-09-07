<?php

namespace fewbricks\acf;

/**
 * Class layout
 * @package fewbricks\acf
 */
class layout
{

    private $settings;

    /**
     * @param $key
     * @param string $name
     * @param string $label
     */
    public function __construct($label, $name, $key)
    {

        $this->settings = [
            'key' => $key,
            'name' => $name,
            'label' => $label,
            'display' => 'row',
            'min' => '',
            'max' => '',
            'sub_fields' => []
        ];

    }

    /**
     * @param $arg
     */
    public function add_field($arg)
    {

        wp_die('Message from Fewbricks: In order to be consistent with ACFs terminology, there is no function <code>add_field</code> for layouts. Use <code>add_sub_field</code> instead.');

    }

    /**
     * @param \fewbricks\acf\fields\field $field_object
     * @return $this
     */
    public function add_sub_field($field_object)
    {

        $this->settings['sub_fields'][] = $field_object->get_settings($this);

        return $this;

    }

    /**
     * Dont add more than one brick to a layout
     * @param \fewbricks\bricks\brick $brick
     * @return $this
     */
    public function add_brick($brick)
    {

        $brick_fields = $brick->get_settings($this)['fields'];

        foreach ($brick_fields as $brick_field) {

            $this->settings['sub_fields'][] = $brick_field;

        }

        // Set name and label of layout to that of the brick
        $this->set_setting('name', $brick->get_setting('name'));

        if($this->get_setting('label') === '') {

            $this->set_setting('label', $brick->get_setting('label'));

        }

    }

    /**
     * @param \fewbricks\acf\fields\repeater $repeater
     */
    public function add_repeater($repeater)
    {

        $this->add_sub_field($repeater);

    }

    /**
     * @param \fewbricks\acf\fields\flexible_content $flexible_content
     */
    public function add_flexible_content($flexible_content)
    {

        $this->add_sub_field($flexible_content);

    }

    /**
     * @param $name
     * @param $value
     */
    public function set_setting($name, $value)
    {

        $this->settings[$name] = $value;

    }

    /**
     * @param $name
     * @return mixed
     */
    public function get_setting($name)
    {

        return $this->settings[$name];


    }

    /**
     * @return array
     */
    public function get_settings()
    {

        return $this->settings;

    }

}