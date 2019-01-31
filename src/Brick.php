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

    const CLASS_ID_STRING = 'brick';

    /**
     * @var array
     */
    protected $data;

    /**
     * @var bool True if the brick is a layout for flexible content
     */
    protected $isLayout;

    /**
     * @var bool True if the brick belongs to an ACF options page.
     */
    protected $isOption;

    /**
     * @var bool True if the brick is a sub field for a repeater
     */
    protected $isSubField;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var int What post id we should get field from.
     */
    private $postIdToGetFieldFrom;

    /**
     * @param string $key This value must be unique system wide. See the documentation for more info on this.
     * Note that it only needs to be set when registering the brick to a field group, layout etc. There's no need to
     * pass it when called from the frontend to print the brick.
     * @param string|boolean $name Name to use when fetching data for the brick. Set to false to use constant NAME
     * @param array $arguments Arbitrary arguments you want to pass to a brick instance to be used within your brick
     * class. This base class does not take any of those arguments into consideration.
     */
    public function __construct(string $key = '', $name = false, array $arguments = [])
    {

        $this->data = [];
        $this->isLayout = false;
        $this->isOption = false;
        $this->isSubField = false;
        $this->postIdToGetFieldFrom = false;

        if($name === false) {
            $this->name = static::NAME;
        } else {
            $this->name = $name;
        }

        parent::__construct($key, $arguments);

    }

    /**
     * @param Field $item
     */
    protected function finalizeItem($item)
    {

        $item->add_parent($this->get_key(), $this->get_name(), self::CLASS_ID_STRING);

    }

    /**
     * @return string
     */
    public function get_name()
    {

        return $this->name;

    }

    /**
     * Returns an instance of a brick that belongs to the current brick. This function takes care of passing its own
     * name and whether it is a layout, sub field or option down to the new instance. You can ovveride if the child
     * should be a layout, sub field or option by passing any of the arguments to this function.
     *
     * @param string $className
     * @param string $brickName
     * @param bool $isLayout If the child brick is a layout.
     * @param bool $isSubField If the child brick is a sub field
     * @param bool $isOption If the child brick is an option. All field swill be fetched using ACFs "option"
     * argument.
     *
     * @return object An instance of the class passed as $className with the name of $brick_name prepended with the
     * name of the current brick.
     */
    public function getChildBrick(string $className, string $brickName, bool $isLayout = false,
                                  bool $isSubField = false, bool $isOption = false)
    {

        // If no special case has been forced on the function call...
        if ($isLayout === false && $isSubField === false && $isOption === false) {

            // ...let the calling (parent) object decide
            $isLayout = $this->isLayout;
            $isSubField = $this->isSubField;
            $isOption = $this->isOption;
            $brickName = $this->name . '_' . $brickName;

        }

        return (new $className($brickName))
            ->setIsLayout($isLayout)
            ->setIsSubField($isSubField)
            ->setIsOption($isOption);

    }

    /**
     * @return array|bool
     */
    public function getData()
    {

        return $this->data;

    }

    /**
     * @return array
     */
    public function getViewData()
    {

        return [];

    }

    /**
     * @param array $data
     * @return $this
     */
    public function setData(array $data)
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
     * @param array $fieldNames
     *
     * @return array
     */
    public function getFieldValues(array $fieldNames)
    {

        $values = [];

        foreach ($fieldNames AS $fieldName) {

            if (is_array($fieldName)) {

                $key = key($fieldName);
                $values[$fieldName[$key]] = $this->getFieldValue($key);

            } else {

                $values[$fieldName] = $this->getFieldValue($fieldName);

            }
        }

        return $values;

    }

    /**
     * @param string $fieldName The first parameter to pass to ACFs get_field-function. This value may be changed
     * inside the function depending on the values of other parameters.
     * @param bool $postId Second parameter to pass to ACFs get_field-function
     * @param bool $formatValue Third parameter to pass to ACFs get_field-function
     * @param bool $prependCurrentObjectsName If the current objects name should be prepended to $data_name
     * @param bool $getFromSubField
     *
     * @return bool|mixed|null
     *
     * @link https://www.advancedcustomfields.com/resources/get_sub_field/
     * @link https://www.advancedcustomfields.com/resources/get_field/
     */
    protected function getFieldValue(string $fieldName, $postId = false, $formatValue = true,
                                     bool $prependCurrentObjectsName = true, bool $getFromSubField = false
    )
    {

        if ($prependCurrentObjectsName) {

            if (substr($fieldName, 0, 1) !== '_') {
                $fieldName = '_' . $fieldName;
            }

            $name = $this->name . $fieldName;

        } else {

            $name = $fieldName;

        }

        if ($postId === false && $this->postIdToGetFieldFrom !== false) {
            $postId = $this->postIdToGetFieldFrom;
        }

        $dataValue = null;

        // Do we have some manually set data?
        if ($this->data !== false && array_key_exists($name, $this->data)) {

            $dataValue = $this->data[$name];

        } else if ($postId === false && ($getFromSubField || $this->isLayout || $this->isSubField)) {

            // We should get data using acf functions and we are dealing with layout or sub field

            // Is it an ACF option?
            // get_sub_field can not deal with "option". Error in fewbricks 1
            /*if ($this->is_option === true) {

                if (null !== ($value = get_sub_field($name, 'options'))) {

                    $data_value = $value;

                }

            } else {*/
            // Not ACF option

            if (null !== ($value = get_sub_field($name, $formatValue))) {

                $dataValue = $value;

            }

            //}

        } else {
            // ACF data which is not a layout or sub field

            if ($this->isOption === true) {

                if (null !== ($value = get_field($name, 'options', $formatValue))) {

                    $dataValue = $value;

                }

            } else if (null !== ($value = get_field($name, $postId, $formatValue))) {

                $dataValue = $value;

            }

        }

        return $dataValue;

    }

    /**
     * @return bool
     */
    public function getIsLayout()
    {

        return $this->isLayout;

    }

    /**
     * @param $isLayout
     * @return $this
     */
    public function setIsLayout($isLayout)
    {

        $this->isLayout = $isLayout;

        return $this;

    }

    /**
     * @return bool
     */
    public function getIsOption()
    {

        return $this->isOption;

    }

    /**
     * @param $isOption
     * @return $this
     */
    public function setIsOption($isOption)
    {

        $this->isOption = $isOption;

        return $this;

    }

    /**
     * @return bool
     */
    public function getIsSubField()
    {

        return $this->isSubField;

    }

    /**
     * @param $isSubField
     *
     * @return $this
     */
    public function setIsSubField($isSubField)
    {

        $this->isSubField = $isSubField;

        return $this;

    }

    /**
     * @return mixed
     */
    public function getPostIdToGetFieldFrom()
    {

        return $this->postIdToGetFieldFrom;

    }

    /**
     * Set a value that should be passed as the second argument to ACFs get_field.
     * Note that it can also be options, taxonomies, users etc. For more info, see "Get a value from different
     * objects" at the link below.
     *
     * @link http://www.advancedcustomfields.com/resources/get_field/
     *
     * @param $postId
     * @return $this
     */
    public function setPostIdToGetFieldFrom($postId)
    {

        $this->postIdToGetFieldFrom = $postId;

        return $this;

    }

    /**
     * Checks if the brick has a layout with the name that you pass to the function. Returns true if it does, false if
     * not.
     *
     * @param string $brickLayoutName
     *
     * @return boolean True if the brick has a layout with the passed name, false if not.
     */
    /*public function hasBrickLayout($brickLayoutName)
    {

        return in_array($brickLayoutName, $this->brickLayouts);

    }*/

    /**
     * Use this to set custom data for the brick.
     *
     * @param string $itemName The name of the item.
     * @param mixed $value The value of the item.
     * @param bool $groupName Use this if you want to create groups of data.
     * @return $this
     */
    public function setDataItem($itemName, $value, $groupName = false)
    {

        if ($groupName === false) {

            $this->data[$itemName] = $value;

        } else {

            $this->data[$groupName][$itemName] = $value;

        }

        return $this;

    }

    /**
     * This function, which is empty on purpose, will automatically be called when instantiating a brick class. You can
     * uses this fact by overriding it in your own Brick classes and adding code for adding your own fields or bricks
     * or whatever you want.
     */
    public function set_up()
    {

    }

}
