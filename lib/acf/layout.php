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

        $brick->set_is_layout(true);

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
     * @param string $common_field_array_key A key corresponding to an item in the fewbricks_common_fields array
     * @param string $key A site wide unique key for the field
     * @param array $settings Anye extra settings to set on the field. Can be used to override existing settings as well.
     */
    protected function add_common_field($common_field_array_key, $key, $settings = []) {

        global $fewbricks_common_fields;

        if(isset($fewbricks_common_fields[$common_field_array_key])) {

            $field = clone $fewbricks_common_fields[$common_field_array_key];
            /** @noinspection PhpUndefinedMethodInspection */
            $field->set_setting('key', $key);
            /** @noinspection PhpUndefinedMethodInspection */
            $field->set_settings($settings);
            $this->add_sub_field($field);

        }

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
     * @param $key
     * @param string $default_value
     * @return string
     */
    public function get_setting($key, $default_value = '') {

        $value = $default_value;

        if(isset($this->settings[$key])) {

            $value = $this->settings[$key];

        }

        return $value;

    }

    /**
     * @return array
     */
    public function get_settings()
    {

        return $this->settings;

    }

}