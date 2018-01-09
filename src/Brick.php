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
    protected $brickLayouts;

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
     * @var array
     */
    private $getHtmlArguments;

    /**
     * @var string
     */
    private $key;

    /**
     * @var int What post id we should get field from.
     */
    private $postIdToGetFieldFrom;

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

        $this->brickLayouts         = [];
        $this->data                 = [];
        $this->isLayout             = false;
        $this->isOption             = false;
        $this->isSubField           = false;
        $this->postIdToGetFieldFrom = false;

        parent::__construct($arguments);

    }

    /**
     * Add a single layout to the brick. String with the name of the layout (without .php).
     * Layout files must be placed in [theme]/fewbricks/brick-layouts/.
     *
     * @param string $brickLayout
     */
    public function addBrickLayout($brickLayout)
    {

        // Avoid nesting brick layouts
        $this->brickLayouts[$brickLayout] = $brickLayout;

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

        return $this->brickLayouts;

    }

    /**
     * Set brick layouts.
     *
     * @param string|array $brickLayouts  Array or string with the name of the layout(s) (without .php).
     *                                    Layout files must be placed in [theme]/fewbricks/brick-layouts/.
     */
    public function setBrickLayouts($brickLayouts)
    {

        if (is_string($brickLayouts)) {

            $brickLayouts = [$brickLayouts];

        }

        if (is_array($brickLayouts)) {

            foreach ($brickLayouts AS $brickLayout) {

                $this->addBrickLayout($brickLayout);

            }

        }

    }

    /**
     * Executes a template file for the current class and returns the output.
     *
     * @param array       $data             Array of data to pass to the template file
     * @param bool|string $templateFilePath If you want to set a specific base path, pass it here. End with a slash.
     *
     * @return string
     */
    protected function getBrickTemplateHtml(array $data = [], $templateFilePath = false)
    {

        if ($templateFilePath === false) {

            $templateFilePath = Helper::getBrickTemplatesBasePath($this) . Helper::getBrickTemplateFileName($this);

        }

        ob_start();

        /** @noinspection PhpIncludeInspection */
        include($templateFilePath);

        return ob_get_clean();

    }

    /**
     *
     *
     * @param string $className
     * @param string $brickName
     * @param bool   $isLayout   If the child brick is a layout.
     * @param bool   $isSubField If the child brick is a sub field
     * @param bool   $isOption   If the child brick is an option. All field swill be fetched using ACFs "option"
     *                           argument.
     *
     * @return object An instance of the class passed as $className
     */
    public function getChildBrick($className, $brickName, $isLayout = false, $isSubField = false, $isOption = false)
    {

        // If no special case has been forced on the function call...
        if ($isLayout === false && $isSubField === false && $isOption === false) {

            // Let the calling object decide
            $isLayout   = $this->isLayout;
            $isSubField = $this->isSubField;
            $isOption   = $this->isOption;
            $brickName  = $this->name . '_' . $brickName;

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
     * @param array $data
     *
     * @return brick $this
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
     * @param array $fieldNames
     *
     * @return array
     */
    public function getFieldValues(array $fieldNames)
    {

        $values = [];

        foreach ($fieldNames AS $fieldName) {

            if (is_array($fieldName)) {

                $key                      = key($fieldName);
                $values[$fieldName[$key]] = $this->getFieldValue($key);

            } else {

                $values[$fieldName] = $this->getFieldValue($fieldName);

            }
        }

        return $values;

    }

    /**
     * @param string $dataName                  The first parameter to pass to ACFs get_field-function. This value may be changed
     *                                          inside the function depending on the values of other parameters.
     * @param bool   $postId                    Second parameter to pass to ACFs get_field-function
     * @param bool   $formatValue               Third parameter to pass to ACFs get_field-function
     * @param bool   $prependCurrentObjectsName If the current objects name should be prepended to $dataName
     * @param bool   $getFromSubField
     *
     * @return bool|mixed|null
     *
     * @link https://www.advancedcustomfields.com/resources/get_sub_field/
     * @link https://www.advancedcustomfields.com/resources/get_field/
     */
    protected function getFieldValue(
        $dataName,
        $postId = false,
        $formatValue = true,
        $prependCurrentObjectsName = true,
        $getFromSubField = false
    ) {

        if ($prependCurrentObjectsName) {

            if (substr($dataName, 0, 1) !== '_') {
                $dataName = '_' . $dataName;
            }

            $name = $this->name . $dataName;

        } else {

            $name = $dataName;

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
     * Get value of html_arg.
     *
     * @param string $name
     * @param mixed  $defaultValue Value to return if the arg has not been set
     *
     * @return bool
     */
    public function getGetHtmlArg($name, $defaultValue = false)
    {

        if (isset($this->getHtmlArguments[$name])) {

            $outcome = $this->getHtmlArguments[$name];

        } else {

            $outcome = $defaultValue;

        }

        return $outcome;

    }

    /**
     * @param array $arguments    Any arguments that you need to pass to the brick on runtime.
     *                            Available as $this->getHtmlArguments
     * @param mixed $brickLayouts Array or string with the file name(s) (without .php) of any layouts that you want to
     *                            wrap the brick in. Use the filter fewbricks/brick_layouts_base_path to change the
     *                            base path of the brick layout files.
     *
     * @return string
     */
    public function getHtml($arguments = [], $brickLayouts = false)
    {

        $this->setBrickLayouts($brickLayouts);

        $this->getHtmlArguments = $arguments;

        return $this->getBrickLayoutedHtml($this->getBrickHtml());

    }

    /**
     * @param $html
     *
     * @return string
     */
    public function getBrickLayoutedHtml($html)
    {

        if (!empty($this->brickLayouts)) {

            $layoutsBasePath = Helper::getBrickLayoutsBasePath();

            foreach ($this->brickLayouts AS $brickLayout) {

                ob_start();

                /** @noinspection PhpIncludeInspection */
                include $layoutsBasePath . '/' . $brickLayout . '.php';

                $html = ob_get_clean();

            }

        }

        return $html;

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
     *
     * @return Brick
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
     *
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
     */
    public function setPostIdToGetFieldFrom($postId)
    {

        $this->postIdToGetFieldFrom = $postId;

    }

    /**
     * Checks if the brick has a layout with the name that you pass to the function. Returns true if it does, false if
     * not.
     *
     * @param string $brickLayoutName
     *
     * @return boolean True if the brick has a layout with the passed name, false if not.
     */
    public function hasBrickLayout($brickLayoutName)
    {

        return in_array($brickLayoutName, $this->brickLayouts);

    }

    /**
     * Use this to set custom data for the brick.
     *
     * @param string $itemName  The name of the item.
     * @param mixed  $value     The value of the item.
     * @param bool   $groupName Use this if you want to create groups of data.
     */
    public function setDataItem($itemName, $value, $groupName = false)
    {

        if ($groupName === false) {

            $this->data[$itemName] = $value;

        } else {

            $this->data[$groupName][$itemName] = $value;

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
