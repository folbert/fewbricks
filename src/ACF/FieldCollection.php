<?php

namespace Fewbricks\ACF;

use Fewbricks\Brick;
use Fewbricks\Collection;

/**
 * Class FieldCollection
 *
 * @package Fewbricks\ACF
 */
class FieldCollection extends Collection implements FieldCollectionInterface
{

    /**
     * @var array
     */
    private $arguments;

    /**
     * @var string
     */
    private $base_key;

    /**
     * String to prefix labels of all the fields in the collection with.
     * @var string
     */
    private $field_labels_prefix;

    /**
     * String to suffix labels of all the fields in the collection with.
     * @var string
     */
    private $field_labels_suffix;

    /**
     * String to prefix field names of all the fields in the collection with.
     * @var string
     */
    private $field_names_prefix;

    /**
     * @var array
     */
    private $fields_settings;

    /**
     * @var boolean
     */
    private $prepared_for_acf_array;

    /**
     * FieldCollection constructor.
     *
     * @param array $arguments
     */
    public function __construct(array $arguments = [])
    {

        $this->arguments = $arguments;
        $this->field_names_prefix = '';
        $this->field_labels_prefix = '';
        $this->field_labels_suffix = '';
        $this->fields_settings = [];
        $this->prepared_for_acf_array = false;

        parent::__construct();

    }

    /**
     * @param Brick $brick
     * @return $this
     */
    public function addBrick(Brick $brick)
    {

        $this->prepareBrickForAdd($brick);
        $this->addFields($brick->getFields());

        return $this;

    }

    /**
     * @param array $bricks
     */
    public function addBricks(array $bricks) {

        foreach($bricks AS $brick) {
            $this->addBrick($brick);
        }

    }

    /**
     * @param Brick $brick
     */
    private function prepareBrickForAdd(Brick &$brick)
    {

        $brick->setFields();
        $brick->prepareForAcfArray();

    }

    /**
     * @param FieldCollection|array $fields
     * @return $this
     */
    public function addFields($fields)
    {

        if (is_array($fields)) {

            foreach ($fields AS $field) {

                $this->addField($field);

            }

        } else if ($fields instanceof FieldCollection) {

            $this->addFieldCollection($fields);

        }

        return $this;

    }

    /**
     * @return mixed
     */
    public function getFields()
    {

        return $this->getItems();

    }

    /**
     * Prepares all fields in the collection for being transformed to an array. This must be called before creating
     * an ACF array and should be called just before doing so.
     */
    protected function prepareForAcfArray()
    {

        if (!$this->prepared_for_acf_array) {

            /** @var Field $field */
            foreach ($this->items AS &$field) {

                $field->prefixName($this->field_names_prefix);
                $field->prefixLabel($this->field_labels_prefix);
                $field->suffixLabel($this->field_labels_suffix);

                if (
                    isset($this->fields_settings[$field->getOriginalKey()]) &&
                    $this->fields_settings[$field->getOriginalKey()] !== false
                ) {

                    $field->setSettings($this->fields_settings[$field->getOriginalKey()]);

                }

            }

        }

        $this->prepared_for_acf_array = true;

    }

    /**
     * @param Field $field
     * @return $this
     */
    public function addField(Field $field)
    {

        parent::addItem($field, $field->getKey());

        return $this;

    }

    /**
     * @param FieldCollection $fieldCollection
     * @return $this
     */
    public function addFieldCollection(FieldCollection $fieldCollection)
    {

        $fieldCollection->prepareForAcfArray();

        $this->addFields($fieldCollection->getFields());

        return $this;

    }

    /**
     * @param Brick $brick
     * @param string $fieldNameToAddAfter
     * @return $this
     */
    public function addBrickAfterByName(Brick $brick, $fieldNameToAddAfter)
    {

        $this->prepareBrickForAdd($brick);

        $this->addFieldsAfterByName($brick->getFields(), $fieldNameToAddAfter);

        return $this;

    }

    /**
     * @param array $fields
     * @param string $fieldNameToAddAfter
     * @return $this
     */
    public function addFieldsAfterByName(array $fields, string $fieldNameToAddAfter)
    {

        // Reverse the array to add the fields in the desired order
        $fields = array_reverse($fields);

        foreach ($fields AS $field) {

            $this->addFieldAfterByName($field, $fieldNameToAddAfter);

        }

        return $this;

    }

    /**
     * @param Field $field
     * @param string $fieldNameToAddAfter
     * @return $this
     */
    public function addFieldAfterByName(Field $field, string $fieldNameToAddAfter)
    {

        /** @var Field $fieldToAddAfter */
        $fieldToAddAfter = $this->getFieldByName($fieldNameToAddAfter);

        if ($fieldToAddAfter !== false) {

            parent::addItemAfter($field, $fieldToAddAfter->getKey(), $field->getKey());

        }

        return $this;

    }

    /**
     * @param $name
     *
     * @return bool|mixed
     */
    public function getFieldByName($name)
    {

        $field = false;

        /**
         * @var string $itemKey
         * @var Field $possibleField
         */
        foreach ($this->items AS $itemKey => $possibleField) {

            if ($possibleField->getName() === $name) {

                $field = parent::getItem($itemKey);
                break;

            }

        }

        return $field;

    }

    /**
     * @param Brick $brick
     * @param string $fieldNameToAddBefore
     * @return $this
     */
    public function addBrickBeforeByName(Brick $brick, string $fieldNameToAddBefore)
    {

        $this->prepareBrickForAdd($brick);

        $this->addFieldsBeforeByName($brick->getFields(), $fieldNameToAddBefore);

        return $this;

    }

    /**
     * @param array $fields
     * @param string $fieldNameToAddBefore
     * @return $this
     */
    public function addFieldsBeforeByName(array $fields, string $fieldNameToAddBefore)
    {

        foreach ($fields AS $field) {

            $this->addFieldBeforeByName($field, $fieldNameToAddBefore);

        }

        return $this;

    }

    /**
     * @param Field $field
     * @param string $fieldNameToAddBefore
     * @return $this
     */
    public function addFieldBeforeByName(Field $field, $fieldNameToAddBefore)
    {

        /** @var Field $itemToAddAfter */
        $fieldToAddBefore = $this->getFieldByName($fieldNameToAddBefore);

        if ($fieldToAddBefore !== false) {

            parent::addItemBefore($field, $fieldToAddBefore->getKey(), $field->getKey());

        }

        return $this;

    }

    /**
     * @param Brick $brick
     * @return $this
     */
    public function addBrickToBeginning(Brick $brick)
    {

        $this->prepareBrickForAdd($brick);

        // Since we wil be using addFields, lets reverse fields order to make sure they are added in the correct order
        $this->addFieldsToBeginning($brick->getFields());

        return $this;

    }

    /**
     * @param FieldCollection|array $fields
     * @return $this
     */
    public function addFieldsToBeginning($fields)
    {

        if (is_array($fields)) {

            $keyedFields = [];

            /** @var Field $field */
            foreach ($fields AS $field) {

                $keyedFields[$field->getKey()] = $field;

            }

            $this->addItemsToBeginning($keyedFields);

        } else if ($fields instanceof FieldCollection) {

            $this->addFieldCollectionToBeginning($fields);

        }

        return $this;

    }

    /**
     * @param FieldCollection $fieldCollection
     * @return $this
     */
    public function addFieldCollectionToBeginning(FieldCollection $fieldCollection)
    {

        $fieldCollection->prepareForAcfArray();

        $this->addFieldsToBeginning($fieldCollection->getItems());

        return $this;

    }

    /**
     * Set ACF settings on fields in this collection. The values will be applied as they are so don't use this to set
     * keys or conditional logic.
     *
     * @param string $fieldKey The original key (the one set when a field was created) of a field in this collection...
     * @param string $settingsName Should correspond to the name of an ACF setting.
     * @param mixed $settingsValue A valid value for the setting.
     * @return $this
     */
    public function addFieldSetting($fieldKey, $settingsName, $settingsValue)
    {

        if (!isset($this->fields_settings[$fieldKey])) {

            $this->fields_settings[$fieldKey] = [];

        }

        $this->fields_settings[$fieldKey][$settingsName] = $settingsValue;

        return $this;

    }

    /**
     * @param Field $field
     * @return $this
     */
    public function addFieldToBeginning(Field $field)
    {

        $this->addItemToBeginning($field, $field->getKey());

        return $this;

    }

    /**
     * @param string $name
     * @param null $default_value Value to return if arg is not set
     *
     * @return mixed|null
     */
    public function getArgument(string $name, $default_value = null)
    {

        return (isset($this->arguments[$name]) ? $this->arguments[$name] : $default_value);

    }

    /**
     * Removes all fields that came from the brick with the passed key.
     *
     * @param string $key
     * @return $this
     */
    public function removeBrickByKey(string $key)
    {

        /** @var Field $field */
        foreach ($this->items AS $fieldKey => $field) {

            if ($field->getParentBrickKey() === $key) {
                $this->removeItem($fieldKey);
            }

        }

        return $this;

    }

    /**
     * Removes all fields that came from the brick with the passed name.
     *
     * @param string $name
     * @return $this
     */
    public function removeBrickByName($name)
    {

        /** @var Field $field */
        foreach ($this->items AS $fieldKey => $field) {

            if ($field->getParentBrickName() === $name) {
                $this->removeItem($fieldKey);
            }

        }

        return $this;

    }

    /**
     * @param array $keys
     * @return $this
     */
    public function removeFieldsByKey(array $keys)
    {

        foreach ($keys AS $key) {

            $this->removeFieldByKey($key);

        }

        return $this;

    }

    /**
     * @param string $key
     * @return $this
     */
    public function removeFieldByKey($key)
    {

        if (substr($key, 0, 6) !== 'field_') {
            $key = 'field_' . $key;
        }

        $this->removeItem($key);

        return $this;

    }

    /**
     * Remove a bunch of fields in one function call. Utilizes the function removeField. Note that the actual removal
     * of the field does not take place until the collection is finalized.
     *
     * @param array $fieldNames Array of names of fields to remove.
     * @return $this
     */
    public function removeFieldsByName(array $fieldNames)
    {

        foreach ($fieldNames AS $fieldName) {

            $this->removeFieldByName($fieldName);

        }

        return $this;

    }

    /**
     * Removes a field from the collection. Note that the actual removal does not take place until the collection is
     * finalized.
     *
     * @param string $fieldName The name of a field. Not the key, not the label, the name.
     * @return $this
     */
    public function removeFieldByName($fieldName)
    {

        /** @var Field $field */
        foreach ($this->items AS $itemKey => $field) {

            if ($field->getName() === $fieldName) {

                parent::removeItem($itemKey);

            }

        }

        return $this;

    }

    /**
     * @param array $arguments
     * @return $this
     */
    public function addArguments(array $arguments)
    {

        foreach ($arguments as $name => $value) {

            $this->addArgument($name, $value);

        }

        return $this;

    }

    /**
     * @param string $name
     * @param mixed $value
     * @return $this
     */
    public function addArgument($name, $value)
    {

        $this->arguments[$name] = $value;

        return $this;

    }

    /**
     * Set a string that will be prefixed to the labels of the fields that are added to this field group.
     *
     * @param $prefix
     * @return $this
     */
    public function setFieldLabelsprefix($prefix)
    {

        $this->field_labels_prefix = $prefix;

        return $this;

    }

    /**
     * Set a string that will be prefixed to the names of the fields that are added to this field group.
     *
     * @param string $prefix
     * @return $this
     */
    public function setFieldNamesprefix($prefix)
    {

        $this->field_names_prefix = $prefix;

        return $this;

    }

    /**
     * @return array An array that ACF can work with.
     */
    public function toAcfArray()
    {

        $this->prepareForAcfArray();

        $acfArray = [];

        /** @var Field $field */
        foreach ($this->items AS $field) {

            $field->prefixKey($this->getBaseKey() . '_');

            $acfArray[] = $field->toAcfArray();

        }

        $acfArray = $this->prepareFieldsConditionalLogic($acfArray);

        return $acfArray;

    }

    /**
     * @return mixed
     */
    public function getBaseKey()
    {

        return $this->base_key;

    }

    /**
     * @param string $base_key
     * @return $this
     */
    public function setBaseKey($base_key)
    {

        $this->base_key = $base_key;

        return $this;

    }

    /**
     * @param array $fields_settings
     *
     * @return mixed
     */
    private function prepareFieldsConditionalLogic($fields_settings)
    {

        // Conditional logic for ACF is made up of a three-levelled array where the first level is the entire logic,
        // the second level are groups (whose relations are OR) and the third level are items (whose relations are AND).

        foreach ($fields_settings AS $field_settings_key => $field_settings) {

            // Do the field have conditional logic
            if (isset($field_settings['conditional_logic'])
                && is_array($field_settings['conditional_logic'])
            ) {

                $conditional_logic_groups = $field_settings['conditional_logic'];

                // Traverse down the conditional logic array
                foreach ($conditional_logic_groups AS $conditional_logic_group_key => $conditional_logic_group_value) {

                    foreach (
                        $conditional_logic_groups[$conditional_logic_group_key] AS
                        $conditional_logic_item_key => $conditional_logic_item_value
                    ) {

                        $target_field_key
                            = $conditional_logic_groups[$conditional_logic_group_key][$conditional_logic_item_key]['field'];

                        // Loop all other items in this collection
                        /** @var Field $other_field_object */
                        foreach ($this->items AS $other_field_object) {

                            if ($other_field_object->getOriginalKey() === $target_field_key) {

                                $conditional_logic_groups[$conditional_logic_group_key][$conditional_logic_item_key]['field']
                                    = $other_field_object->getKey();

                            }

                        }

                    }

                }

                $fields_settings[$field_settings_key]['conditional_logic'] = $conditional_logic_groups;

            }

        }

        return $fields_settings;

    }

}
