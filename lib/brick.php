<?php

namespace fewbricks\bricks;

use fewbricks\acf as acf;

/**
 * Class brick
 * @package fewbricks\bricks
 */
class brick
{

    /**
     * @var string The name of the brick
     */
    private $name;

    /**
     * @var string The key of the brick. Must be unique across the site.
     */
    private $key;

    /**
     * @var bool True if the brick is a layout for flexible content
     */
    protected $is_layout;

    /**
     * @var bool True if the brick belongs to an ACF options page.
     */
    protected $is_option;

    /**
     * @var bool True if the brick is a sub field for a repeater
     */
    protected $is_sub_field;

    /**
     * @var array The fields that the brick have.
     */
    private $fields;

    /**
     * @var string An optional text to prepend to the labels of the fields of the brick.
     */
    private $field_label_prefix;

    /**
     * @var string An optional text to append to the labels of the fields of the brick.
     */
    private $field_label_suffix;

    /**
     * @var bool|array Data for the brick
     */
    protected $data = false;

    /**
     * @var array Extra settings to allow for greater flexibility for the arguments.
     */
    protected $settings;

    /**
     * @var array Extra settings that is passed to get_html() / get_brick_html()
     */
    protected $get_html_args;

    /**
     * @var array A place to store arbitrary arguments.
     */
    protected $args;

    /**
     * @var array What post id we should get field from.
     */
    private $post_id_to_get_field_from;

    /**
     * @var array Any layouts that the brick has if it is a flexible content.
     */
    private $layouts;

    /**
     * @var array Any fields that we should remove will be added to this array.
     */
    private $fields_to_remove;

    /**
     * @var boolean True if the brick is sub brick of another brick.
     */
    protected $is_sub_brick;

    /**
     * @var array Any brick layouts that should be used when ouputting the brick.
     */
    private $brick_layouts;

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
        $this->post_id_to_get_field_from = false;
        $this->args = [];
        $this->data = [];
        $this->layouts = [];
        $this->fields_to_remove = [];
        $this->is_sub_brick = false;
        $this->brick_layouts = [];

        $this->args['brick_css_class'] = [];

    }

    /**
     * @param array $data
     * @return brick $this
     */
    public function set_data($data)
    {

        $this->data = $data;

        return $this;

    }

    /**
     * Get settings of a field.
     * @param \fewbricks\acf\field-group|\fewbricks\acf\layout|\fewbricks\acf\fields\repeater|\fewbricks\acf\fields\flexible_content|\fewbricks\bricks\brick $object_to_get_for
     * @return array
     */
    public function get_settings($object_to_get_for)
    {

        $this->prepare_settings($object_to_get_for);

        /** @noinspection PhpUndefinedMethodInspection */
        $this->set_fields();
        /** @noinspection PhpUndefinedMethodInspection */
        $this->set_project_fields();
        $this->remove_fields();

        if (is_a($object_to_get_for, 'fewbricks\acf\layout')) {

            $this->set_is_layout(true);

            // We need a hidden field to tell us what class we are dealing with when looping layouts in the frontend.
            $this->add_field((new acf\fields\fewbricks_hidden('Brick class', 'brick_class', '7001010000a'))
                ->set_setting('default_value', \fewbricks\helpers\get_real_class_name($this)));

        } elseif (is_a($object_to_get_for, 'fewbricks\acf\fields\repeater')) {

            $this->set_is_sub_field(true);

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
     * Add a field to the brick.
     * @param \fewbricks\acf\fields\field $field
     * @return mixed
     */
    protected function add_field($field)
    {

        $this->fields[] = $field->get_settings($this);

        return $field;

    }

    /**
     * Add a sub brick to the brick.
     * @param brick $brick_to_add
     */
    protected function add_brick($brick_to_add)
    {

        $this->add_fields($brick_to_add->get_settings($this)['fields']);

    }

    /**
     * Add a repeater to the brick.
     * @param \fewbricks\acf\fields\repeater $repeater
     */
    protected function add_repeater($repeater)
    {

        $this->add_field($repeater);

    }

    /**
     * Add a flexible content to the brick.
     * @param \fewbricks\acf\fields\flexible_content $flexible_content
     */
    protected function add_flexible_content($flexible_content)
    {

        $this->add_field($flexible_content);

    }

    /**
     * Add a common field to the brick.
     * @param string $common_field_array_key A key corresponding to an item in the fewbricks_common_fields array
     * @param string $key A site wide unique key for the field
     * @param array $settings Anye extra settings to set on the field. Can be used to override existing settings as well.
     */
    protected function add_common_field($common_field_array_key, $key, $settings = [])
    {

        global $fewbricks_common_fields;

        if (isset($fewbricks_common_fields[$common_field_array_key])) {

            $field = clone $fewbricks_common_fields[$common_field_array_key];
            /** @noinspection PhpUndefinedMethodInspection */
            $field->set_setting('key', $key);
            /** @noinspection PhpUndefinedMethodInspection */
            $field->set_settings($settings);
            $this->add_field($field);

        }

    }

    /**
     * Set an argument.
     * @param $name
     * @param $value
     * @return $this
     */
    public function set_arg($name, $value)
    {
        $this->args[$name] = $value;

        return $this;
    }

    /**
     * Get an argument.
     * @param string $name The name of the argument to get
     * @param boolean $default The value to return if there is no argument with the sent name.
     * @return mixed The value of the argument or default if the argument ha snot been set
     */
    public function get_arg($name, $default = false)
    {

        $value = $default;

        if (isset($this->args[$name])) {
            $value = $this->args[$name];
        }

        return $value;
    }

    /**
     * Prepare settings of the brick.
     * @param $object_to_prepare_for
     */
    private function prepare_settings($object_to_prepare_for)
    {

        if (!is_a($object_to_prepare_for, '\fewbricks\acf\field_group')) {

            $this->prepare_name($object_to_prepare_for);
            $this->prepare_label($object_to_prepare_for);

        }

    }

    /**
     * @param \fewbricks\acf\fields\repeater|\fewbricks\acf\fields\flexible_content|\fewbricks\bricks\brick $object_to_prepare_for
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
     * @param \fewbricks\acf\fields\repeater|\fewbricks\acf\fields\flexible_content|\fewbricks\bricks\brick $object_to_prepare_for
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
     * @param $data_name
     * @return string
     */
    protected function get_data_name($data_name)
    {

        return $this->name . $data_name;

    }

    /**
     * @param string $repeater_name The name of the repeater that the field with the data is in.
     * @param $data_name
     * @param bool $post_id Specific post id
     * @return bool|mixed|null|void
     */
    protected function get_field_in_repeater($repeater_name, $data_name, $post_id = false)
    {

        return $this->get_field($repeater_name . '_' . $data_name, $post_id, false, true);

    }

    /**
     * @param $data_name
     * @param bool $post_id
     * @param bool $prepend_this_name
     * @param bool $get_from_sub_field
     * @return bool|mixed|null|void
     */
    protected function get_field($data_name, $post_id = false, $prepend_this_name = true, $get_from_sub_field = false)
    {

        if ($prepend_this_name) {

            if (substr($data_name, 0, 1) !== '_') {
                $data_name = '_' . $data_name;
            }

            $name = $this->name . $data_name;

        } else {

            $name = $data_name;

        }

        if ($post_id === false && $this->post_id_to_get_field_from !== false) {
            $post_id = $this->post_id_to_get_field_from;
        }

        $data_value = null;

        // Do we have some manually set data?
        if ($this->data !== false && array_key_exists($name, $this->data)) {

            $data_value = $this->data[$name];

        } elseif ($post_id === false && ($get_from_sub_field || $this->is_layout || $this->is_sub_field)) {

            // We should get data using acf functions and we are dealing with layout or sub field

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

            } elseif (null !== ($value = get_field($name, $post_id))) {

                $data_value = $value;

            }

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
            $outcome = have_rows($this->name . '_' . $name);
        }

        return $outcome;

    }

    /**
     * Wrapper function for ACFs the_row to avoid confucsion on when to use $this or not for ACF functions.
     */
    protected function the_row()
    {

        the_row();

    }

    /**
     * @param $repeater_name
     * @param $brick_name
     * @param $brick_class_name
     * @return mixed
     */
    protected function get_child_brick_in_repeater($repeater_name, $brick_name, $brick_class_name)
    {

        return $this->get_child_brick($brick_class_name, $repeater_name . '_' . $brick_name, false, true);

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

        $brick_class_name = 'fewbricks\bricks\\' . $brick_class_name;

        // If we have not forced either sub field or layout
        if (!$is_layout && !$is_sub_field) {

            $is_layout = $this->is_layout;
            $is_sub_field = $this->is_sub_field;
            $name = $this->name . '_' . $name;

        }

        /** @noinspection PhpUndefinedMethodInspection */
        return (new $brick_class_name($name))
            ->set_is_layout($is_layout)
            ->set_is_sub_field($is_sub_field)
            ->set_is_option($this->is_option);

    }

    /**
     * @param array $args Any arguments that you need to pass to the brick on runtime. Available as $this->get_html_args
     * @param mixed $brick_layouts Any layouts that you want to wrap the brick in. Array or string with the name
     * of the layout (without .php). Layouts must be placed in [theme]/fewbricks/brick-layouts/
     * @return string
     */
    public function get_html($args = [], $brick_layouts = false)
    {

        if (is_string($brick_layouts)) {

            $this->add_brick_layout($brick_layouts);

        } elseif (is_array($brick_layouts)) {

            foreach ($brick_layouts AS $brick_layout) {

                $this->add_brick_layout($brick_layout);

            }

        }

        $this->get_html_args = $args;

        return $this->get_brick_layouted_html($this->get_brick_html());

    }

    /**
     * Executes a template file for the current class and returns the output.
     * @return string
     */
    protected function get_brick_template_html()
    {

        $template_path = get_template_directory() .
            '/fewbricks/bricks/' .
            str_replace('_', '-', \fewbricks\helpers\get_real_class_name($this)) .
            '.template.php';

        ob_start();

        /** @noinspection PhpIncludeInspection */
        include($template_path);

        return ob_get_clean();

    }

    /**
     * @param $html
     * @return string
     */
    public function get_brick_layouted_html($html)
    {

        if (!empty($this->brick_layouts)) {

            $theme_path = get_template_directory() . '/';

            foreach ($this->brick_layouts AS $brick_layout) {

                if(substr($brick_layout, -5) === '.twig') {

                    $html = \Timber::compile($theme_path . 'fewbricks/brick-layouts/' . $brick_layout, [
                        'html' => $html,
                        'this' => $this
                    ]);

                } else {

                    ob_start();

                    /** @noinspection PhpIncludeInspection */
                    include($theme_path . 'fewbricks/brick-layouts/' . $brick_layout . '.php');

                    $html = ob_get_clean();

                }

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
     * @return $this
     */
    public function set_is_layout($is_layout)
    {

        $this->is_layout = $is_layout;

        return $this;

    }

    /**
     * @param $is_option
     * @return $this
     */
    public function set_is_option($is_option)
    {

        $this->is_option = $is_option;

        return $this;

    }

    /**
     * @param $is_sub_field
     * @return $this
     */
    public function set_is_sub_field($is_sub_field)
    {

        $this->is_sub_field = $is_sub_field;

        return $this;

    }

    /**
     * @param $key
     * @return $this
     */
    public function set_key($key)
    {

        $this->key = $key;
        return $this;

    }

    /**
     * @param $name
     * @return $this
     */
    public function set_name($name)
    {

        $this->name = $name;
        return $this;

    }

    /**
     * @param $label
     * @return $this
     */
    public function set_label($label)
    {

        /** @noinspection PhpUndefinedFieldInspection */
        $this->label = $label;
        return $this;

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
     * @return $this
     */
    public function set_field_label_suffix($suffix)
    {

        $this->field_label_suffix = $suffix;
        return $this;

    }

    /**
     * This function makes sure that we have means to get essential settings in the same way as for fields etc.
     * @param $name
     * @param $value
     * @return $this
     */
    public function set_setting($name, $value)
    {

        $this->{$name} = $value;
        return $this;


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
     * @return string
     */
    public function get_name()
    {

        return $this->name;

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

    /**
     * Set a value that should be passed as the second argument to ACFs get_field.
     * Note that it can also be options, taxonomies, users etc.
     * @link http://www.advancedcustomfields.com/resources/get_field/
     * @param $post_id
     */
    public function set_post_id_to_get_field_from($post_id)
    {

        $this->post_id_to_get_field_from = $post_id;

    }

    /**
     * @return bool
     */
    public function get_post_id_to_get_field_from()
    {

        return $this->post_id_to_get_field_from;

    }

    /**
     * @param $brick_layout
     */
    public function add_brick_layout($brick_layout)
    {

        // Avoid nesting brick layouts
        $this->brick_layouts[$brick_layout] = $brick_layout;

    }

    /**
     * Use this to set custom data for the brick.
     * @param $name
     * @param $value
     * @param $prepend_this_name
     */
    public function set_data_item($name, $value, $prepend_this_name = true)
    {

        if ($prepend_this_name) {
            $name = $this->name . '_' . $name;
        }

        $this->data[$name] = $value;

    }

    /**
     *
     */
    private function remove_fields()
    {

        foreach ($this->fields_to_remove AS $field_to_remove) {

            foreach ($this->fields AS $field_key => $field) {

                if ($field['name'] == $field_to_remove) {

                    unset($this->fields[$field_key]);
                    break;

                }

            }

        }

    }

    /**
     * @param $class_name
     */
    public function add_css_class($class_name)
    {

        $this->args['brick_css_class'][] = $class_name;

    }

    /**
     * @param $is_sub_brick
     */
    public function set_is_sub_brick($is_sub_brick)
    {

        $this->is_sub_brick = $is_sub_brick;

    }

    /**
     * @param $sub_brick_name
     * @param $name_setting
     * @return mixed
     */
    protected function create_sub_brick_object($sub_brick_name, $name_setting)
    {

        $sub_brick_name = '\fewbricks\bricks\\' . $sub_brick_name;

        $object = new $sub_brick_name($this->get_name() . '_' . $name_setting);
        /** @noinspection PhpUndefinedMethodInspection */
        $object->set_is_layout($this->is_layout);
        /** @noinspection PhpUndefinedMethodInspection */
        $object->set_is_sub_field($this->is_sub_field);
        /** @noinspection PhpUndefinedMethodInspection */
        $object->set_is_option($this->is_option);

        return $object;

    }

}