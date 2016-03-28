<?php

namespace fewbricks\acf\fields;

/**
 * Class field
 * @package fewbricks\acf\fields
 */
class field
{

    /**
     * @var array
     */
    protected $settings;

    /**
     * @var bool
     */
    private $key_prepared;

    /**
     * @param string $label The label that the field will get.
     * @param string $name The name that the field will get.
     * @param string $key The key that the field wil get. It is very important that this value is unique among
     * all the keys across the entire site.
     * @param array $base_settings
     * @param array $custom_settings Any custom settings that you want to set. A setting must be implemented in the ACF
     * field class for it to have an effect. This array wil be merged with $base_settings in this class and then with
     * the default settings in the ACF field class.
     */
    public function __construct($label, $name, $key, $base_settings = [], $custom_settings = [])
    {

        $this->settings = array_merge($base_settings, $custom_settings);
        $this->settings['label'] = $label;
        $this->settings['name'] = $name;
        $this->settings['key'] = $key;

        $this->key_prepared = false;

    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function set_setting($key, $value)
    {

        $this->settings[$key] = $value;

        return $this;

    }

    /**
     * @param $settings
     * @return $this
     */
    public function set_settings($settings) {

        foreach($settings AS $setting_key => $setting_value) {

            $this->set_setting($setting_key, $setting_value);

        }

        return $this;

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
     * @param \fewbricks\acf\field-groups|\fewbricks\acf\layout|\fewbricks\acf\fields\repeater|\fewbricks\acf\fields\flexible_content|\fewbricks\bricks\brick $object_to_get_for
     * @return array
     */
    public function get_settings($object_to_get_for)
    {

        $this->prepare_settings($object_to_get_for);

        if(is_a($object_to_get_for, 'fewbricks\bricks\brick')) {

            // We will need this later on to build a unique key.
            /** @noinspection PhpUndefinedMethodInspection */
            $this->settings['brick_key'] = $object_to_get_for->get_setting('key');

        }

        return $this->settings;

    }

    /**
     * @param $object_to_prepare_for
     */
    private function prepare_settings($object_to_prepare_for)
    {

        if(!is_a($object_to_prepare_for, 'fewbricks\acf\field_group')) {

            $this->prepare_name($object_to_prepare_for);
            $this->prepare_label($object_to_prepare_for);

        }

    }

    /**
     * @param repeater|flexible_content|\fewbricks\bricks\brick $object_to_prepare_for
     */
    private function prepare_name($object_to_prepare_for) {

        $this->set_setting('name', $object_to_prepare_for->get_setting('name') . '_' . $this->get_setting('name'));

    }

    /**
     * @param $object_to_prepare_for
     */
    private function prepare_label($object_to_prepare_for) {

        $this->prepare_label_addition($object_to_prepare_for, 'prefix');
        $this->prepare_label_addition($object_to_prepare_for, 'suffix');

    }

    /**
     * @param repeater|flexible_content|\fewbricks\bricks\brick $object_to_prepare_for
     * @param $setting
     */
    private function prepare_label_addition($object_to_prepare_for, $setting) {

        if ('' !== ($field_label_addition = $object_to_prepare_for->get_setting('field_label_' . $setting, ''))) {

            if($setting == 'prefix') {

                $new_label = $field_label_addition . ' - ' . $this->get_setting('label');

            } else {

                $new_label = $this->get_setting('label') . ' - ' . $field_label_addition;

            }

            $this->set_setting('label', $new_label);

        }

    }

}