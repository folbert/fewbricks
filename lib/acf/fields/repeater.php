<?php

namespace fewbricks\acf\fields;

/**
 * Class repeater
 * @package fewbricks\acf\fields
 */
class repeater extends field
{

    /**
     * @param string $label The label that the field will get.
     * @param string $name The name that the field will get.
     * @param string $key The key that the field wil get. It is very important that this value is unique among
     * all the keys across the entire site.
     * @param array $custom_settings Any custom settings that you want to set. A setting must be implemented in the ACF
     * field class for it to have an effect. This array wil be merged with $base_settings in this class and then with
     * the default settings in the ACF field class.
     */
    public function __construct($label, $name, $key, $custom_settings = [])
    {

        $base_settings = [
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

        parent::__construct($label, $name, $key, $base_settings, $custom_settings);

    }


    /**
     * @param $arg
     */
    public function add_field($arg)
    {

        wp_die('Message from Fewbricks: In order to be consistent with ACFs terminology, there is no function <code>add_field</code> for repeaters. Use <code>add_sub_field</code> instead.');

    }

    /**
     * @param field $field_object
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

        $brick->set_is_sub_field(true);

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


}