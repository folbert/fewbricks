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
     * @var string
     */
    private $key;

    /**
     * @var int What post id we should get field from.
     */
    private $post_id_to_get_field_from;

    /**
     * @param string $name Name to use when fetching data for the brick.
     * @param string $key This value must be unique system wide. See the documentation for motre info on this.
     * Note that it only needs to be set when registering the brick to a field group, layout etc. There's no need to
     * pass it when called from the frontend to print the brick.
     * @param array $arguments Arbitrary arguments you want to pass to a brick instance to be used within your brick
     * class. This base class does not take any of those arguments into consideration.
     */
    public function __construct($name, $key = '', $arguments = [])
    {

        $this->key = $key;
        $this->name = $name;

        $this->data = [];
        $this->is_layout = false;
        $this->is_option = false;
        $this->is_sub_field = false;
        $this->post_id_to_get_field_from = false;

        parent::__construct($arguments);

    }

    /**
     * Add a field to the brick.
     * @param Field $field
     * @return $this
     */
    public function addField(Field $field)
    {

        $field->prefixKey($this->getKey() . '_');
        $field->prefixName($this->getName() . '_');
        $field->setParentBrickKey($this->getKey());
        $field->setParentBrickName($this->getName());

        parent::addField($field);

        return $this;

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
     * Returns an instance of a brick that belongs to the current brick. This function takes care of passing its own
     * name and whether it is a layout, sub field or option down to the new instance. You can ovveride if the child
     * should be a layout, sub field or option by passing any of the arguments to this function.
     *
     * @param string $class_name
     * @param string $brick_name
     * @param bool $is_layout If the child brick is a layout.
     * @param bool $is_sub_field If the child brick is a sub field
     * @param bool $is_option If the child brick is an option. All field swill be fetched using ACFs "option"
     * argument.
     *
     * @return object An instance of the class passed as $className with the name of $brick_name prepended with the
     * name of the current brick.
     */
    public function getChildBrick($class_name, $brick_name, $is_layout = false, $is_sub_field = false,
                                  $is_option = false)
    {

        // If no special case has been forced on the function call...
        if ($is_layout === false && $is_sub_field === false && $is_option === false) {

            // ...let the calling (parent) object decide
            $is_layout = $this->is_layout;
            $is_sub_field = $this->is_sub_field;
            $is_option = $this->is_option;
            $brick_name = $this->name . '_' . $brick_name;

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
     * @return $this
     */
    public function setData($data)
    {

        $this->data = $data;

        return $this;

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

                $key = key($field_name);
                $values[$field_name[$key]] = $this->getFieldValue($key);

            } else {

                $values[$field_name] = $this->getFieldValue($field_name);

            }
        }

        return $values;

    }

    /**
     * @param string $data_name The first parameter to pass to ACFs get_field-function. This value may be changed
     *                                          inside the function depending on the values of other parameters.
     * @param bool $post_id Second parameter to pass to ACFs get_field-function
     * @param bool $format_value Third parameter to pass to ACFs get_field-function
     * @param bool $prepend_current_objects_name If the current objects name should be prepended to $dataName
     * @param bool $get_from_sub_field
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
    )
    {

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

        $data_value = null;

        // Do we have some manually set data?
        if ($this->data !== false && array_key_exists($name, $this->data)) {

            $data_value = $this->data[$name];

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

                $data_value = $value;

            }

            //}

        } else {
            // ACF data which is not a layout or sub field

            if ($this->is_option === true) {

                if (null !== ($value = get_field($name, 'options', $format_value))) {

                    $data_value = $value;

                }

            } else if (null !== ($value = get_field($name, $post_id, $format_value))) {

                $data_value = $value;

            }

        }

        return $data_value;

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
     * @return $this
     */
    public function setIsLayout($isLayout)
    {

        $this->is_layout = $isLayout;

        return $this;

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
     * @return $this
     */
    public function setIsOption($is_option)
    {

        $this->is_option = $is_option;

        return $this;

    }

    /**
     * @return bool
     */
    public function getIsSubField()
    {

        return $this->is_sub_field;

    }

    /**
     * @param $is_sub_field
     *
     * @return $this
     */
    public function setIsSubField($is_sub_field)
    {

        $this->is_sub_field = $is_sub_field;

        return $this;

    }

    /**
     * @return mixed
     */
    public function getPostIdToGetFieldFrom()
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
     * @return $this
     */
    public function setPostIdToGetFieldFrom($post_id)
    {

        $this->post_id_to_get_field_from = $post_id;

        return $this;

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
     * @param string $item_name The name of the item.
     * @param mixed $value The value of the item.
     * @param bool $group_name Use this if you want to create groups of data.
     * @return $this
     */
    public function setDataItem($item_name, $value, $group_name = false)
    {

        if ($group_name === false) {

            $this->data[$item_name] = $value;

        } else {

            $this->data[$group_name][$item_name] = $value;

        }

        return $this;

    }

    /**
     * This function, which is empty on purpose, will automatically be called when instantiating a brick class. You can
     * uses this fact by overriding it in your own Brick classes and adding code for adding your own fields or bricks
     * or whatever you want. By keeping an empty function here, you don't have to implement an empty function
     * yourself if you, for some reason, want to create a brick that does not have any fields.
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
