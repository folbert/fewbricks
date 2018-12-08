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
     * @var
     */
    private $acfArray;

    /**
     * @var array
     */
    protected $arguments;

    /**
     * @var string
     */
    protected $key;

    /**
     * String to prefix labels of all the fields in the collection with.
     * @var string
     */
    protected $fieldLabelsPrefix;

    /**
     * String to suffix labels of all the fields in the collection with.
     * @var string
     */
    protected $fieldLabelsSuffix;

    /**
     * String to prefix field names of all the fields in the collection with.
     * @var string
     */
    protected $fieldNamesPrefix;

    /**
     * @var boolean
     */
    protected $preparedForAcfArray;

    /**
     * FieldCollection constructor.
     *
     * @param string $key
     * @param array $arguments
     */
    public function __construct(string $key, array $arguments = [])
    {

        $this->key = $key;
        $this->arguments = $arguments;
        $this->fieldNamesPrefix = '';
        $this->fieldLabelsPrefix = '';
        $this->fieldLabelsSuffix = '';
        $this->preparedForAcfArray = false;
        $this->acfArray = false;

        parent::__construct();

    }

    /**
     * @param Brick $brick
     * @return $this
     */
    public function addBrick($brick)
    {

        $this->prepareBrickForAdd($brick);
        $this->addFields($brick->getFields());

        return $this;

    }

    /**
     * @param array $bricks
     */
    public function addBricks(array $bricks)
    {

        foreach ($bricks AS $brick) {
            $this->addBrick($brick);
        }

    }

    /**
     * @return string
     */
    public function getKey()
    {

        return $this->key;

    }

    /**
     * @param Brick $brick
     */
    private function prepareBrickForAdd(&$brick)
    {

        $brick->setup();
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

        if (!$this->preparedForAcfArray) {

            /** @var Field $field */
            foreach ($this->items AS &$field) {

                $field->prefixName($this->fieldNamesPrefix);
                $field->prefixLabel($this->fieldLabelsPrefix);
                $field->suffixLabel($this->fieldLabelsSuffix);

            }

        }

        $this->preparedForAcfArray = true;

    }

    /**
     * @param Field $field
     * @return $this
     */
    public function addField($field)
    {

        parent::addItem($field, $field->getKey());

        return $this;

    }

    /**
     * @param FieldCollection $fieldCollection
     * @return $this
     */
    public function addFieldCollection($fieldCollection)
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
    public function addBrickAfterFieldByName($brick, string $fieldNameToAddAfter)
    {

        $this->prepareBrickForAdd($brick);

        $this->addFieldsAfterFieldByName($brick->getFields(), $fieldNameToAddAfter);

        return $this;

    }

    /**
     * @param array $fields
     * @param string $fieldNameToAddAfter
     * @return $this
     */
    public function addFieldsAfterFieldByName(array $fields, string $fieldNameToAddAfter)
    {

        // Reverse the array to add the fields in the desired order
        $fields = array_reverse($fields);

        foreach ($fields AS $field) {

            $this->addFieldAfterFieldByName($field, $fieldNameToAddAfter);

        }

        return $this;

    }

    /**
     * @param Field $field
     * @param string $fieldNameToAddAfter
     * @return $this
     */
    public function addFieldAfterFieldByName($field, string $fieldNameToAddAfter)
    {

        /** @var Field $fieldToAddAfter */
        $fieldToAddAfter = $this->getFieldByName($fieldNameToAddAfter);

        if ($fieldToAddAfter !== false) {

            parent::addItemAfterItemByKey($field, $fieldToAddAfter->getKey(), $field->getKey());

        }

        return $this;

    }

    /**
     * @param string $name
     * @return bool|mixed
     */
    public function getFieldByName(string $name)
    {

        $field = false;

        /**
         * @var string $itemKey
         * @var Field $possibleField
         */
        foreach ($this->items AS $itemKey => $possibleField) {

            if ($possibleField->getName() === $name) {

                $field = parent::getItemByKey($itemKey);
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
    public function addBrickBeforeFieldByName($brick, string $fieldNameToAddBefore)
    {

        $this->prepareBrickForAdd($brick);

        $this->addFieldsBeforeFieldByName($brick->getFields(), $fieldNameToAddBefore);

        return $this;

    }

    /**
     * @param Field $new_field
     * @param string $key_of_field_to_add_before
     * @return $this
     */
    public function addFieldBeforeFieldByKey($new_field, string $key_of_field_to_add_before)
    {

        parent::addItemBeforeItemByKey($new_field, $key_of_field_to_add_before, $new_field->getKey());

        return $this;

    }

    /**
     * @param Field[] $fields
     * @param string $fieldNameToAddBefore
     * @return $this
     */
    public function addFieldsBeforeFieldByName(array $fields, string $fieldNameToAddBefore)
    {

        foreach ($fields AS $field) {

            $this->addFieldBeforeFieldByName($field, $fieldNameToAddBefore);

        }

        return $this;

    }

    /**
     * @param Field $field
     * @param string $fieldNameToAddBefore
     * @return $this
     */
    public function addFieldBeforeFieldByName($field, string $fieldNameToAddBefore)
    {

        /** @var Field $itemToAddAfter */
        $fieldToAddBefore = $this->getFieldByName($fieldNameToAddBefore);

        if ($fieldToAddBefore !== false) {

            parent::addItemBeforeItemByKey($field, $fieldToAddBefore->getKey(), $field->getKey());

        }

        return $this;

    }

    /**
     * @param Brick $brick
     * @return $this
     */
    public function addBrickToBeginning($brick)
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
    public function addFieldCollectionToBeginning($fieldCollection)
    {

        $fieldCollection->prepareForAcfArray();

        $this->addFieldsToBeginning($fieldCollection->getItems());

        return $this;

    }

    /**
     * @param Field $field
     * @return $this
     */
    public function addFieldToBeginning($field)
    {

        $this->addItemToBeginning($field, $field->getKey());

        return $this;

    }

    /**
     * @param string $argument_name
     * @param null $default_value Value to return if arg is not set
     *
     * @return mixed|null
     */
    public function getArgument(string $argument_name, $default_value = null)
    {

        return (isset($this->arguments[$argument_name]) ? $this->arguments[$argument_name] : $default_value);

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

            foreach($field->getParents() AS $parentData) {

                if ($parentData['type'] === Brick::CLASS_ID_STRING && $parentData['key'] === $key) {
                    $this->removeItem($fieldKey);
                    break;
                }

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
    public function removeBrickByName(string $name)
    {

        /** @var Field $field */
        foreach ($this->items AS $fieldKey => $field) {

            foreach($field->getParents() AS $parentData) {

                if ($parentData['type'] === Brick::CLASS_ID_STRING && $parentData['name'] === $name) {
                    $this->removeItem($fieldKey);
                }

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
    public function removeFieldByKey(string $key)
    {

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
    public function removeFieldByName(string $fieldName)
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
    public function addArgument(string $name, $value)
    {

        $this->arguments[$name] = $value;

        return $this;

    }

    /**
     * @param string $key
     * @return Field|bool
     */
    public function getFieldByOriginalKeyFromObjects(string $key) {

        $foundField = false;

        /** @var Field $field */
        foreach($this->items AS $field) {

            if($field->getOriginalKey() === $key) {

                $foundField = $field;
                break;

            }

        }

        return $foundField;

    }

    /**
     * Set a string that will be prefixed to the labels of the fields that are added to this field group.
     *
     * @param $prefix
     * @return $this
     */
    public function setFieldLabelsPrefix(string $prefix)
    {

        $this->fieldLabelsPrefix = $prefix;

        return $this;

    }

    /**
     * Set a string that will be prefixed to the names of the fields that are added to this field group.
     *
     * @param string $prefix
     * @return $this
     */
    public function setFieldNamesPrefix(string $prefix)
    {

        $this->fieldNamesPrefix = $prefix;

        return $this;

    }

    /**
     * @param $keyOfFieldToReplace
     * @param $newField
     * @return $this
     */
    public function replaceFieldByKey($newField, string $keyOfFieldToReplace)
    {

        $this->addFieldBeforeFieldByKey($newField, $keyOfFieldToReplace);
        $this->removeFieldByKey($keyOfFieldToReplace);

        return $this;

    }

    /**
     * @param $nameOfFieldToReplace
     * @param $newField
     * @return $this
     */
    public function replaceFieldByName($newField, string $nameOfFieldToReplace)
    {

        $this->addFieldBeforeFieldByName($newField, $nameOfFieldToReplace);
        $this->removeFieldByName($nameOfFieldToReplace);

        return $this;

    }

    /**
     * @param string $keyPrefix
     * @return array An array that ACF can work with.
     */
    public function toAcfArray(string $keyPrefix = '')
    {

        $this->prepareForAcfArray();

        $acfArray = [];

        /** @var Field $field */
        foreach ($this->items AS $field) {

            $acfArray[] = $field->toAcfArray($keyPrefix);

        }

        return $acfArray;

    }

}
