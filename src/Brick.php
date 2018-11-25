<?php

namespace Fewbricks;

use Fewbricks\ACF\Field;
use Fewbricks\ACF\FieldCollection;

/**
 * Class Brick
 *
 * @package Fewbricks
 */
class Brick extends FieldCollection implements BrickInterface
{

    /**
     * @var array
     */
    protected $brick_layouts;

    /**
     * @var array
     */
    protected $data;

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
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    private $get_html_arguments;

    /**
     * @var string
     */
    private $key;

    /**
     * @var int What post id we should get field from.
     */
    private $post_id_to_get_field_from;

    /**
     * Brick constructor.
     *
     * @param string $name      Name to use when fetching data for the brick.
     * @param string $key       This value must be unique system wide. See the readme-file for tips on how to achieve this.
     *                          Note that it only needs to be set when registering the brick to a field group, layout etc.
     *                          No need to pass it when called from the frontend to print the brick.
     * @param array  $arguments Arbitrary arguments you want to pass to a brick instance to be used within the brick.
     */
    public function __construct($name, $key = '', $arguments = [])
    {

        $this->key  = $key;
        $this->name = $name;

        $this->brick_layouts         = [];
        $this->data                 = [];
        $this->is_layout             = false;
        $this->is_option             = false;
        $this->is_sub_field           = false;
        $this->post_id_to_get_field_from = false;

        parent::__construct($arguments);

    }

    /**
     * Add a single layout to the brick. String with the name of the layout (without .php).
     * Layout files must be placed in [theme]/fewbricks/brick-layouts/.
     *
     * @param string $brick_layout
     */
    public function addBrickLayout($brick_layout)
    {

        // Avoid nesting brick layouts
        $this->brick_layouts[$brick_layout] = $brick_layout;

    }

    /**
     * @param Field $field
     */
    public function addField(Field $field)
    {

        $field->prefixKey($this->getKey() . '_');
        $field->prefixName($this->getName() . '_');
        $field->setParentBrickKey($this->getKey());
        $field->setParentBrickName($this->getName());

        parent::addField($field);

    }

    /**
     * @return string
     */
    public function getKey()
    {

        return $this->key;

    }

    /**
     * @return string
     */
    public function getName()
    {

        return $this->name;

    }

    /**
     * @return string
     */
    public function getBaseKey()
    {

        return $this->getKey();

    }

    /**
     * Returns the brick layouts set for the brick. These are the values previously passed to set_brick_layouts and/or
     * add_brick_layout.
     *
     * @return array
     */
    public function getBrickLayouts()
    {

        return $this->brick_layouts;

    }

    /**
     * Set brick layouts.
     *
     * @param string|array $brick_layouts  Array or string with the name of the layout(s) (without .php).
     *                                    Layout files must be placed in [theme]/fewbricks/brick-layouts/.
     */
    public function setBrickLayouts($brick_layouts)
    {

        if (is_string($brick_layouts)) {

            $brick_layouts = [$brick_layouts];

        }

        if (is_array($brick_layouts)) {

            foreach ($brick_layouts AS $brick_layout) {

                $this->addBrickLayout($brick_layout);

            }

        }

    }

    /**
     * Executes a template file for the current class and returns the output.
     *
     * @param array       $data             Array of data to pass to the template file
     * @param bool|string $template_file_path If you want to set a specific base path, pass it here. End with a slash.
     *
     * @return string
     */
    protected function getBrickTemplateHtml(array $data = [], $template_file_path = false)
    {

        if ($template_file_path === false) {

            $brick_templates_base_path = Helper::getBrickTemplatesBasePath($this);

            if($brick_templates_base_path !== false) {

                $template_file_path = $brick_templates_base_path . '/' . Helper::getBrickTemplateFileName($this);

            } else {

                wp_die(__('Please make sure that you have used the filter <code>fewbricks/brick_layouts_base_path</code>
to tell Brick::getBrickTemplateHtml() where to look for brick layouts.', 'fewbricks'));

            }

        }

        ob_start();

        /** @noinspection PhpIncludeInspection */
        include($template_file_path);

        return ob_get_clean();

    }

    /**
     *
     *
     * @param string $class_name
     * @param string $brick_name
     * @param bool   $is_layout   If the child brick is a layout.
     * @param bool   $is_sub_field If the child brick is a sub field
     * @param bool   $is_option   If the child brick is an option. All field swill be fetched using ACFs "option"
     *                           argument.
     *
     * @return object An instance of the class passed as $className
     */
    public function getChildBrick($class_name, $brick_name, $is_layout = false, $is_sub_field = false, $is_option = false)
    {

        // If no special case has been forced on the function call...
        if ($is_layout === false && $is_sub_field === false && $is_option === false) {

            // Let the calling object decide
            $is_layout   = $this->is_layout;
            $is_sub_field = $this->is_sub_field;
            $is_option   = $this->is_option;
            $brick_name  = $this->name . '_' . $brick_name;

        }

        return (new $class_name($brick_name))
            ->setIsLayout($is_layout)
            ->setIsSubField($is_sub_field)
            ->setIsOption($is_option);

    }

    /**
     * @return array|bool
     */
    public function getData()
    {

        return $this->data;

    }

    /**
     * @param array $data
     */
    public function setData($data)
    {

        $this->data = $data;

    }

    /**
     * Get multiple field values in one function call. Pass an array where each item can be either:
     * - a field name
     * - an array where the index is the field name and the value is the name you want to store the value as
     * in in the returned array: ['field_name_1', 'field_name_2', ['field_name_3' => 'name_to_save_as']]
     * Does not support passing extra arguments to getFieldValue().
     *
     * @param array $field_names
     *
     * @return array
     */
    public function getFieldValues(array $field_names)
    {

        $values = [];

        foreach ($field_names AS $field_name) {

            if (is_array($field_name)) {

                $key                      = key($field_name);
                $values[$field_name[$key]] = $this->getFieldValue($key);

            } else {

                $values[$field_name] = $this->getFieldValue($field_name);

            }
        }

        return $values;

    }

    /**
     * @param string $data_name                  The first parameter to pass to ACFs get_field-function. This value may be changed
     *                                          inside the function depending on the values of other parameters.
     * @param bool   $post_id                    Second parameter to pass to ACFs get_field-function
     * @param bool   $format_value               Third parameter to pass to ACFs get_field-function
     * @param bool   $prepend_current_objects_name If the current objects name should be prepended to $dataName
     * @param bool   $get_from_sub_field
     *
     * @return bool|mixed|null
     *
     * @link https://www.advancedcustomfields.com/resources/get_sub_field/
     * @link https://www.advancedcustomfields.com/resources/get_field/
     */
    protected function getFieldValue(
        $data_name,
        $post_id = false,
        $format_value = true,
        $prepend_current_objects_name = true,
        $get_from_sub_field = false
    ) {

        if ($prepend_current_objects_name) {

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

        $dataValue = null;

        // Do we have some manually set data?
        if ($this->data !== false && array_key_exists($name, $this->data)) {

            $dataValue = $this->data[$name];

        } else if ($post_id === false && ($get_from_sub_field || $this->is_layout || $this->is_sub_field)) {

            // We should get data using acf functions and we are dealing with layout or sub field

            // Is it an ACF option?
            // get_sub_field can not deal with "option". Error in fewbricks 1
            /*if ($this->is_option === true) {

                if (null !== ($value = get_sub_field($name, 'options'))) {

                    $data_value = $value;

                }

            } else {*/
            // Not ACF option

            if (null !== ($value = get_sub_field($name, $format_value))) {

                $dataValue = $value;

            }

            //}

        } else {
            // ACF data which is not a layout or sub field

            if ($this->is_option === true) {

                if (null !== ($value = get_field($name, 'options', $format_value))) {

                    $dataValue = $value;

                }

            } else if (null !== ($value = get_field($name, $post_id, $format_value))) {

                $dataValue = $value;

            }

        }

        return $dataValue;

    }

    /**
     * Get value of html_arg.
     *
     * @param string $name
     * @param mixed  $default_value Value to return if the arg has not been set
     *
     * @return bool
     */
    public function getGetHtmlArg($name, $default_value = false)
    {

        if (isset($this->get_html_arguments[$name])) {

            $outcome = $this->get_html_arguments[$name];

        } else {

            $outcome = $default_value;

        }

        return $outcome;

    }

    /**
     * @param array $arguments    Any arguments that you need to pass to the brick on runtime.
     *                            Available as $this->getHtmlArguments
     * @param mixed $brick_layouts Array or string with the file name(s) (without .php) of any layouts that you want to
     *                            wrap the brick in. Use the filter fewbricks/brick_layouts_base_path to change the
     *                            base path of the brick layout files.
     *
     * @return string
     */
    public function getHtml($arguments = [], $brick_layouts = false)
    {

        $this->setBrickLayouts($brick_layouts);

        $this->get_html_arguments = $arguments;

        return $this->getBrickLayoutedHtml($this->getBrickHtml());

    }

    /**
     * @param $html
     *
     * @return string
     */
    public function getBrickLayoutedHtml($html)
    {

        if(false === ($layouts_base_path = Helper::getBrickLayoutsBasePath())) {
            return $html;
        }

        if(empty($this->brick_layouts)) {
            return $html;
        }

        foreach ($this->brick_layouts AS $brick_layout) {

            ob_start();

            /** @noinspection PhpIncludeInspection */
            include $layouts_base_path . '/' . $brick_layout . '.php';

            $html = ob_get_clean();

        }

        return $html;

    }

    /**
     * @return bool
     */
    public function getIsLayout()
    {

        return $this->is_layout;

    }

    /**
     * @param $isLayout
     */
    public function setIsLayout($isLayout)
    {

        $this->is_layout = $isLayout;

    }

    /**
     * @return bool
     */
    public function getIsOption()
    {

        return $this->is_option;

    }

    /**
     * @param $is_option
     */
    public function setIsOption($is_option)
    {

        $this->is_option = $is_option;

    }

    /**
     * @return bool
     */
    public function getIsSubfield()
    {

        return $this->is_sub_field;

    }

    /**
     * @param $is_sub_field
     *
     * @return $this
     */
    public function setIsSubfield($is_sub_field)
    {

        $this->is_sub_field = $is_sub_field;

    }

    /**
     * @return mixed
     */
    public function getPostIdtogetfieldfrom()
    {

        return $this->post_id_to_get_field_from;

    }

    /**
     * Set a value that should be passed as the second argument to ACFs get_field.
     * Note that it can also be options, taxonomies, users etc. For more info, see "Get a value from different
     * objects" at the link below.
     *
     * @link http://www.advancedcustomfields.com/resources/get_field/
     *
     * @param $post_id
     */
    public function setPostIdToGetFieldFrom($post_id)
    {

        $this->post_id_to_get_field_from = $post_id;

    }

    /**
     * Checks if the brick has a layout with the name that you pass to the function. Returns true if it does, false if
     * not.
     *
     * @param string $brick_layout_name
     *
     * @return boolean True if the brick has a layout with the passed name, false if not.
     */
    public function hasBrickLayout($brick_layout_name)
    {

        return in_array($brick_layout_name, $this->brick_layouts);

    }

    /**
     * Use this to set custom data for the brick.
     *
     * @param string $item_name  The name of the item.
     * @param mixed  $value     The value of the item.
     * @param bool   $group_name Use this if you want to create groups of data.
     */
    public function setDataItem($item_name, $value, $group_name = false)
    {

        if ($group_name === false) {

            $this->data[$item_name] = $value;

        } else {

            $this->data[$group_name][$item_name] = $value;

        }

    }

    /**
     *
     */
    public function setFields()
    {

    }

    /**
     * @return array
     */
    public function toAcfArray()
    {

        return parent::toAcfArray();

    }

}
