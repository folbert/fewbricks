<?php

namespace fewbricks\acf\fields;

/**
 * Class field
 * @package fewbricks\acf
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
     * @param string $label
     * @param string $name
     * @param string $key
     * @param $settings
     */
    public function __construct($label, $name, $key, $settings)
    {

        $this->settings = $settings;
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
     * @param $object_to_get_for
     * @return array
     */
    public function get_settings($object_to_get_for)
    {

        $this->prepare_settings($object_to_get_for);

        return $this->settings;

    }

    /**
     * @param $object_to_prepare_for
     */
    private function prepare_settings($object_to_prepare_for)
    {

        if(!$this->key_prepared) {

            $this->prepare_key($object_to_prepare_for);

        }

        if(isset($this->settings['sub_fields'])) {

            $this->prepare_sub_fields($object_to_prepare_for);

        }

        if(!is_a($object_to_prepare_for, 'fewbricks\acf\field_group')) {

            $this->prepare_name($object_to_prepare_for);
            $this->prepare_label($object_to_prepare_for);

        }

        $this->prepare_conditional_logic($object_to_prepare_for);

    }

    /**
     * @param $object_to_prepare_for
     */
    protected function prepare_key($object_to_prepare_for) {

        $this->set_setting('key', $object_to_prepare_for->get_setting('key') . '_' . $this->get_setting('key'));

        $this->key_prepared = true;

    }

    /**
     * @param $object_to_prepare_for
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
     * @param $object_to_prepare_for
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

    /**
     * @param $object_to_prepare_for
     */
    private function prepare_conditional_logic($object_to_prepare_for) {

        if(isset($this->settings['conditional_logic']) && !empty($this->settings['conditional_logic']))
        {

            foreach($this->settings['conditional_logic'] AS $lvl_1_key => $lvl_1_value) {

                foreach($this->settings['conditional_logic'][$lvl_1_key] AS $lvl_2_key => $lvl_2_value) {

                    $this->settings['conditional_logic'][$lvl_1_key][$lvl_2_key]['field'] =
                        $object_to_prepare_for->get_setting('key') . '_' .
                        $this->settings['conditional_logic'][$lvl_1_key][$lvl_2_key]['field'];

                }

            }

        }

    }

    /**
     * @param $object_to_prepare_for
     */
    private function prepare_sub_fields($object_to_prepare_for)
    {

        $key_of_object_to_prepare_for = $object_to_prepare_for->get_setting('key');

        foreach ($this->settings['sub_fields'] AS $sub_field_array_key => $sub_field) {

            // Lets make the key for the sub fields unique across the site.
            $this->settings['sub_fields'][$sub_field_array_key]['key'] =
                $key_of_object_to_prepare_for . '_' . $sub_field['key'];

            // Lets fix the conditional logic
            if(isset($sub_field['conditional_logic']) && !empty($sub_field['conditional_logic'])) {

                foreach($sub_field['conditional_logic'] AS $lvl_1_key => $lvl_1_value) {

                    foreach($sub_field['conditional_logic'][$lvl_1_key] AS $lvl_2_key => $lvl_2_value) {

                        $this->settings['sub_fields'][$sub_field_array_key]['conditional_logic'][$lvl_1_key][$lvl_2_key]['field'] =
                            $key_of_object_to_prepare_for . '_' .
                            $sub_field['conditional_logic'][$lvl_1_key][$lvl_2_key]['field'];

                    }

                }

            }

        }

    }

}