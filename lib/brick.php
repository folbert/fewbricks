<?php

/**
 * @todo Enable removing settings. Like brick name for text in flexible columns. And then remove brick name for demos.
 * @todo Improve acf.js
 */

namespace fewbricks\bricks;

use fewbricks\acf as acf;

/**
 * Class brick
 * @package fewbricks\bricks
 */
class brick
{

    /**
     * @var Name
     */
    private $name;

    /**
     * @var string
     */
    private $key;

    /**
     * @var bool
     */
    private $is_layout;

    /**
     * @var bool
     */
    private $is_option;

    /**
     * @var bool
     */
    private $is_sub_field;

    /**
     * @var array
     */
    private $fields;

    /**
     * @var string
     */
    private $field_label_prefix;

    /**
     * @var
     */
    private $field_label_suffix;

    /**
     * @var bool|array
     */
    protected $data = false;

    /**
     * Extra settings to allow for greater flexibility for the arguments.
     * @var array
     */
    protected $settings;

    /**
     * @var
     */
    protected $view;


    /**
     * @param string $name Name to use when fetching data for the brick
     * @param string $key This value must be unique system wide. See the readme-file for tips on how to achieve this.
     *  Note that it only needs to be set when registering the brick to a field group, layout etc. No need to pass it
     *  when called from the frontend to print the brick.
     */
    public function __construct($name, $key = '')
    {

        $this->name = $name;
        $this->key = $key;
        $this->is_layout = false;
        $this->is_sub_field = false;
        $this->is_option = false;
        $this->fields = [];
        $this->field_label_prefix = '';
        $this->field_label_suffix = '';
        $this->data = [];
        $this->view = false;

    }

    /**
     * @param $data
     * @return $this
     */
    public function set_data($data)
    {

        $this->data = $data;

        return $this;

    }

    /**
     * @return array
     */
    public function get_settings($object_to_get_for)
    {

        $this->prepare_settings($object_to_get_for);

        $this->set_fields();

        if (is_a($object_to_get_for, 'fewbricks\acf\layout')) {

            $this->set_is_layout(true);

            // We need a hidden field to tell us what class we are dealing with when looping layouts in the frontend.
            $this->add_field((new acf\fields\hidden('Brick class', 'brick_class', '7001010000a'))
                ->set_setting('default_value', \fewbricks\helpers\get_real_class_name($this)));

        } else {
            if (is_a($object_to_get_for, 'fewbricks\acf\fields\repeater')) {

                $this->set_is_sub_field(true);

            }
        }

        return [
            'name' => $this->name,
            'key' => $this->key,
            'is_layout' => $this->is_layout,
            'is_sub_field' => $this->is_sub_field,
            'is_option' => $this->is_option,
            'fields' => $this->fields,
            'field_label_prefix' => $this->field_label_prefix,
            'field_label_suffix' => $this->field_label_suffix
        ];

    }

    /**
     * Get settings for a field of the brick. We need this function since we modify
     * the key of the field by adding the key of the brick and therefore can not call the field directly.
     * @param $field_name
     * @return field|false
     */
    public function get_field_by_name($field_name)
    {

        $settings = false;

        foreach ($this->fields AS $field) {

            if ($field['name'] == $field_name) {

                $settings = $field;
                break;

            }

        }

        return $settings;

    }

    /**
     * @param \fewbricks\acf\fields\field $field
     * @return mixed
     */
    protected function add_field($field)
    {

        $this->fields[] = $field->get_settings($this);

        return $field;

    }

    /**
     * @param brick $brick_to_add
     */
    protected function add_brick($brick_to_add)
    {

        $this->add_fields($brick_to_add->get_settings($this)['fields']);

    }

    /**
     * @param $repeater_to_add
     */
    protected function add_repeater($repeater_to_add)
    {

        $this->add_field($repeater_to_add);

    }

    /**
     * @param $object_to_prepare_for
     */
    private function prepare_settings($object_to_prepare_for)
    {

        $this->prepare_key($object_to_prepare_for);

        if (!is_a($object_to_prepare_for, '\fewbricks\acf\field_group')) {

            $this->prepare_name($object_to_prepare_for);
            $this->prepare_label($object_to_prepare_for);

        }

    }

    /**
     * @param $object_to_prepare_for
     */
    private function prepare_key($object_to_prepare_for)
    {

        $this->set_key($object_to_prepare_for->get_setting('key') . '_' . $this->get_setting('key'));

    }

    /**
     * @param $object_to_prepare_for
     */
    private function prepare_name($object_to_prepare_for)
    {

        $this->set_name($object_to_prepare_for->get_setting('name') . '_' . $this->get_setting('name'));

    }

    /**
     * @param $object_to_prepare_for
     */
    private function prepare_label($object_to_prepare_for)
    {

        $this->prepare_label_addition($object_to_prepare_for, 'prefix');
        $this->prepare_label_addition($object_to_prepare_for, 'suffix');

    }

    /**
     * @param $object_to_prepare_for
     * @param $setting
     */
    private function prepare_label_addition($object_to_prepare_for, $setting)
    {

        if ('' !== ($field_label_extra = $object_to_prepare_for->get_setting('field_label_' . $setting, ''))) {

            // If the break we are dealing with has a prefix, we need to respect that.
            if ('' !== ($my_field_label_extra = $this->get_setting('field_label_' . $setting, ''))) {

                $field_label_extra .= ' - ' . $my_field_label_extra;

            }

            $this->set_setting('field_label_' . $setting, $field_label_extra);

        }

    }

    /**
     * @param $common_field_name
     */
    protected function add_common_field($common_field_name)
    {

    }

    /**
     * @param $repeater
     */
    /*
    protected function add_repeater($repeater)
    {

        $this->fields[] = $repeater->get_settings();

    }
    */

    /**
     * @param flexible_content $flexible_content
     */
    /*
    protected function add_flexible_content($flexible_content) {

        $flexible_content->set_name($this->name . '_' . $flexible_content->get_name());
        $flexible_content->set_key($this->key . '_' . $flexible_content->get_key());

    }
    */

    /**
     * @param $data_name
     * @return string
     */
    protected function get_data_name($data_name)
    {

        return $this->name . $data_name;

    }

    /**
     * @param $data_key
     * @param $repeater_name The name of the repeater that the field with the data is in.
     * @return bool|mixed|null|void
     */
    protected function get_data_value_in_repeater($data_key, $repeater_name)
    {

        //return $this->get_data_value($repeater_name . '_' . $data_key, false, true);

    }

    /**
     * @param $data_key
     * @param bool $prepend_this_name
     * @param bool $get_from_sub_field
     * @return bool|mixed|null|void
     */
    protected function get_data_value($data_key, $prepend_this_name = true, $get_from_sub_field = false)
    {

        if ($prepend_this_name) {

            if (substr($data_key, 0, 1) !== '_') {
                $data_key = '_' . $data_key;
            }

            $name = $this->name . $data_key;

        } else {

            $name = $data_key;

        }

        $data_value = null;

        $fetched_from_custom_data = false;

        // Do we have some manually set data?
        if ($this->data !== false && array_key_exists($name, $this->data)) {

            $data_value = $this->data[$name];
            $fetched_from_custom_data = true;

        } elseif ($get_from_sub_field || $this->is_layout || $this->is_sub_field) {

            // We should get data using acf functions and we are dealign with
            // layout or sub field

            // Is it an ACF option?
            if ($this->is_option === true) {

                if (null !== ($value = get_sub_field($name, 'options'))) {

                    $data_value = $value;

                }

            } else {
                // Not ACF option

                if (null !== ($value = get_sub_field($name))) {

                    $data_value = $value;

                }

            }

        } else {
            // ACF data which is not a layout or sub field

            if ($this->is_option === true) {

                if (null !== ($value = get_field($name, 'options'))) {

                    $data_value = $value;

                }

            } else {

                if (null !== ($value = get_field($name))) {

                    $data_value = $value;

                }

            }

        }

        // Make sure we have something to return
        if (!$fetched_from_custom_data && is_null($data_value)) {

            die('brick->get_data_value() - data not found for name "' . $name . '"');

        }

        return $data_value;

    }

    /**
     * Wrapper function for ACFs have_rows()
     * @param $name
     * @return bool
     */
    protected function have_rows($name)
    {

        if ($this->is_option) {
            $outcome = have_rows($this->get_data_name('_' . $name), 'option');
        } else {
            $outcome = have_rows($name);
        }

        return $outcome;

    }

    /**
     * @param $brick_class_name
     * @param $repeater_name
     * @param $brick_name
     * @return mixed
     */
    protected function get_child_brick_in_repeater($brick_class_name, $repeater_name, $brick_name)
    {

        //return $this->get_child_brick($brick_class_name, $repeater_name . '_' . $brick_name, false, true);

    }

    /**
     * Returns an instance of a class with the name of $brick_class_name as an ACF layout in flexible content.
     * @param string $brick_class_name The name of the class to get.
     * @param $name
     * @param bool $is_layout
     * @param bool $is_sub_field
     * @return mixed
     */
    protected function get_child_brick($brick_class_name, $name, $is_layout = false, $is_sub_field = false)
    {

        /*
        $brick_class_name = 'fewbricks\bricks\\' . $brick_class_name;

        // If we are currently in a layout, we know that any child is also in a layout.
        if (!$is_layout) {
            $is_layout = $this->is_layout;
        }

        // If we are currently in a sub field, we know that any child is also in a sub field.
        if (!$is_sub_field) {
            $is_sub_field = $this->is_sub_field;
        }

        return (new $brick_class_name($this->name . '_' . $name))
            ->set_is_layout($is_layout)
            ->set_is_sub_field($is_sub_field)
            ->set_is_option($this->is_option);
        */

    }

    /**
     * @param array $args
     * @param bool|false $layouts
     * @return string
     */
    public function get_html($args = [], $layouts = false) {

        $html = $this->get_brick_html($args);

        if($layouts === false) {
            $html = $this->get_layouted_html($html);
        }

        return $html;

    }

    /**
     * @param $html
     * @param string|array $layouts
     * @return string
     */
    public function get_layouted_html($html, $layouts = [])
    {

        if (is_string($layouts)) {
            $layouts = [$layouts];
        }

        if (!empty($layouts)) {

            foreach ($layouts AS $layout) {

                ob_start();

                include(__DIR__ . '/../layouts/' . $layout . '.php');

                $html = ob_get_clean();

            }

        }

        return $html;

    }

    /**
     * @param $fields_to_add
     */
    public function add_fields($fields_to_add)
    {

        foreach ($fields_to_add AS $field_to_add) {

            $this->fields[] = $field_to_add;

        }


    }

    /**
     * @param $is_layout
     */
    public function set_is_layout($is_layout)
    {

        $this->is_layout = $is_layout;

    }

    /**
     * @param $is_option
     */
    public function set_is_option($is_option)
    {

        $this->is_option = $is_option;

    }

    /**
     * @param $is_sub_field
     */
    public function set_is_sub_field($is_sub_field)
    {

        $this->is_sub_field = $is_sub_field;

    }

    /**
     * @param $key
     */
    public function set_key($key)
    {

        $this->key = $key;

    }

    /**
     * @param $name
     */
    public function set_name($name)
    {

        $this->name = $name;

    }

    /**
     * @param $prefix
     * @return $this
     */
    public function set_field_label_prefix($prefix)
    {

        $this->field_label_prefix = $prefix;

        return $this;

    }

    /**
     * @param $suffix
     */
    public function set_field_label_suffix($suffix)
    {

        $this->field_label_suffix = $suffix;

        return $this;

    }

    /**
     * This function makes sure that we have means to get essential settings in the same way as for fields etc.
     * @param $name
     * @return string
     */
    public function set_setting($name, $value)
    {

        $this->{$name} = $value;


    }

    /**
     * @return array|bool
     */
    public function get_data()
    {

        return $this->data;

    }

    /**
     * @return bool
     */
    public function get_is_option()
    {

        return $this->is_option;

    }

    /**
     * @return bool
     */
    public function get_is_sub_field()
    {

        return $this->is_sub_field;

    }

    /**
     * @return bool
     */
    public function get_is_layout()
    {

        return $this->is_layout;

    }

    /**
     * This function makes sure that we have means to get essential settings in the same way as for fields etc.
     * @param string $name
     * @param string $default_value
     * @return string
     */
    public function get_setting($name, $default_value = '')
    {

        $value = $this->{$name};

        if ($value === null) {

            $value = $default_value;

        }

        return $value;


    }


}