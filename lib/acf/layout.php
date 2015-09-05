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
     * @param array $layout_settings
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
     * Dont add more than one brick to a layout
     * @param \fewbricks\bricks\brick $brick
     * @internal param array $args
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
        $this->set_setting('label', $brick->get_setting('label'));

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