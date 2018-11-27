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
    protected $arguments;

    /**
     * @var string
     */
    protected $base_key;

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
     */
    public function addBrick(Brick $brick)
    {

        $this->prepareBrickForAdd($brick);
        $this->addFields($brick->getFields());

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
     */
    public function addField(Field $field)
    {

        parent::addItem($field, $field->getKey());

    }

    /**
     * @param FieldCollection $fieldCollection
     */
    public function addFieldCollection(FieldCollection $fieldCollection)
    {

        $fieldCollection->prepareForAcfArray();

        $this->addFields($fieldCollection->getFields());

    }

    /**
     * @param Brick $brick
     * @param string $fieldNameToAddAfter
     */
    public function addBrickAfterByName(Brick $brick, $fieldNameToAddAfter)
    {

        $this->prepareBrickForAdd($brick);

        $this->addFieldsAfterByName($brick->getFields(), $fieldNameToAddAfter);

    }

    /**
     * @param array $fields
     * @param string $fieldNameToAddAfter
     */
    public function addFieldsAfterByName(array $fields, string $fieldNameToAddAfter)
    {

        // Reverse the array to add the fields in the desired order
        $fields = array_reverse($fields);

        foreach ($fields AS $field) {

            $this->addFieldAfterByName($field, $fieldNameToAddAfter);

        }

    }

    /**
     * @param Field $field
     * @param string $fieldNameToAddAfter
     */
    public function addFieldAfterByName(Field $field, string $fieldNameToAddAfter)
    {

        /** @var Field $fieldToAddAfter */
        $fieldToAddAfter = $this->getFieldByName($fieldNameToAddAfter);

        if ($fieldToAddAfter !== false) {

            parent::addItemAfter($field, $fieldToAddAfter->getKey(), $field->getKey());

        }

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
     */
    public function addBrickBeforeByName(Brick $brick, string $fieldNameToAddBefore)
    {

        $this->prepareBrickForAdd($brick);

        $this->addFieldsBeforeByName($brick->getFields(), $fieldNameToAddBefore);

    }

    /**
     * @param array $fields
     * @param string $fieldNameToAddBefore
     */
    public function addFieldsBeforeByName(array $fields, string $fieldNameToAddBefore)
    {

        foreach ($fields AS $field) {

            $this->addFieldBeforeByName($field, $fieldNameToAddBefore);

        }

    }

    /**
     * @param Field $field
     * @param string $fieldNameToAddBefore
     */
    public function addFieldBeforeByName(Field $field, $fieldNameToAddBefore)
    {

        /** @var Field $itemToAddAfter */
        $fieldToAddBefore = $this->getFieldByName($fieldNameToAddBefore);

        if ($fieldToAddBefore !== false) {

            parent::addItemBefore($field, $fieldToAddBefore->getKey(), $field->getKey());

        }

    }

    /**
     * @param Brick $brick
     */
    public function addBrickToBeginning(Brick $brick)
    {

        $this->prepareBrickForAdd($brick);

        // Since we wil be using addFields, lets reverse fields order to make sure they are added in the correct order
        $this->addFieldsToBeginning($brick->getFields());

    }

    /**
     * @param FieldCollection|array $fields
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

    }

    /**
     * @param FieldCollection $fieldCollection
     */
    public function addFieldCollectionToBeginning(FieldCollection $fieldCollection)
    {

        $fieldCollection->prepareForAcfArray();

        $this->addFieldsToBeginning($fieldCollection->getItems());

    }

    /**
     * Set ACF settings on fields in this collection. The values will be applied as they are so don't use this to set
     * keys or conditional logic.
     *
     * @param string $fieldKey The original key (the one set when a field was created) of a field in this collection...
     * @param string $settingsName Should correspond to the name of an ACF setting.
     * @param mixed $settingsValue A valid value for the setting.
     */
    public function addFieldSetting($fieldKey, $settingsName, $settingsValue)
    {

        if (!isset($this->fields_settings[$fieldKey])) {

            $this->fields_settings[$fieldKey] = [];

        }

        $this->fields_settings[$fieldKey][$settingsName] = $settingsValue;

    }

    /**
     * @param Field $field
     */
    public function addFieldToBeginning(Field $field)
    {

        $this->addItemToBeginning($field, $field->getKey());

    }

    /**
     * @param string $name
     * @param null $defaultValue Value to return if arg is not set
     *
     * @return mixed|null
     */
    public function getArgument(string $name, $defaultValue = null)
    {

        return (isset($this->arguments[$name]) ? $this->arguments[$name] : $defaultValue);

    }

    /**
     * Removes all fields that came from the brick with the passed key.
     *
     * @param string $key
     */
    public function removeBrickByKey(string $key)
    {

        /** @var Field $field */
        foreach ($this->items AS $fieldKey => $field) {

            if ($field->getParentBrickKey() === $key) {
                $this->removeItem($fieldKey);
            }

        }

    }

    /**
     * Removes all fields that came from the brick with the passed name.
     *
     * @param string $name
     */
    public function removeBrickByName($name)
    {

        /** @var Field $field */
        foreach ($this->items AS $fieldKey => $field) {

            if ($field->getParentBrickName() === $name) {
                $this->removeItem($fieldKey);
            }

        }

    }

    /**
     * @param array $keys
     */
    public function removeFieldsByKey(array $keys)
    {

        foreach ($keys AS $key) {

            $this->removeFieldByKey($key);

        }

    }

    /**
     * @param string $key
     */
    public function removeFieldByKey($key)
    {

        if (substr($key, 0, 6) !== 'field_') {
            $key = 'field_' . $key;
        }

        $this->removeItem($key);

    }

    /**
     * Remove a bunch of fields in one function call. Utilizes the function removeField. Note that the actual removal
     * of the field does not take place until the collection is finalized.
     *
     * @param array $fieldNames Array of names of fields to remove.
     */
    public function removeFieldsByName(array $fieldNames)
    {

        foreach ($fieldNames AS $fieldName) {

            $this->removeFieldByName($fieldName);

        }

    }

    /**
     * Removes a field from the collection. Note that the actual removal does not take place until the collection is
     * finalized.
     *
     * @param string $fieldName The name of a field. Not the key, not the label, the name.
     */
    public function removeFieldByName($fieldName)
    {

        /** @var Field $field */
        foreach ($this->items AS $itemKey => $field) {

            if ($field->getName() === $fieldName) {

                parent::removeItem($itemKey);

            }

        }

    }

    /**
     * @param array $arguments
     */
    public function setArguments(array $arguments)
    {

        foreach ($arguments as $name => $value) {

            $this->setArgument($name, $value);

        }

    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function setArgument($name, $value)
    {

        $this->arguments[$name] = $value;

    }

    /**
     * Set a string that will be prefixed to the labels of the fields that are added to this field group.
     *
     * @param $prefix
     */
    public function setFieldLabelsprefix($prefix)
    {

        $this->field_labels_prefix = $prefix;

    }

    /**
     * Set a string that will be prefixed to the names of the fields that are added to this field group.
     *
     * @param string $prefix
     */
    public function setFieldNamesprefix($prefix)
    {

        $this->field_names_prefix = $prefix;

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
     */
    public function setBaseKey($base_key)
    {

        $this->base_key = $base_key;

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
