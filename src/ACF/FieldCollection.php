<?php

namespace Fewbricks\ACF;

use Fewbricks\Brick;
use Fewbricks\Collection;
use Fewbricks\Helper;

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
    private $acf_array;

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
    protected $field_labels_prefix;

    /**
     * String to suffix labels of all the fields in the collection with.
     * @var string
     */
    protected $field_labels_suffix;

    /**
     * String to prefix field names of all the fields in the collection with.
     * @var string
     */
    protected $field_names_prefix;

    /**
     * @var boolean
     */
    protected $prepared_for_acf_array;

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
        $this->field_names_prefix = '';
        $this->field_labels_prefix = '';
        $this->field_labels_suffix = '';
        $this->prepared_for_acf_array = false;
        $this->acf_array = false;

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
    public function addBricks(array $bricks)
    {

        foreach ($bricks AS $brick) {
            $this->addBrick($brick);
        }

    }

    public function getKey()
    {

        return $this->key;

    }

    /**
     * @param Brick $brick
     */
    private function prepareBrickForAdd(Brick &$brick)
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

        if (!$this->prepared_for_acf_array) {

            /** @var Field $field */
            foreach ($this->items AS &$field) {

                $field->prefixName($this->field_names_prefix);
                $field->prefixLabel($this->field_labels_prefix);
                $field->suffixLabel($this->field_labels_suffix);

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
    public function addBrickAfterFieldByName(Brick $brick, $fieldNameToAddAfter)
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
    public function addFieldAfterFieldByName(Field $field, string $fieldNameToAddAfter)
    {

        /** @var Field $fieldToAddAfter */
        $fieldToAddAfter = $this->getFieldByName($fieldNameToAddAfter);

        if ($fieldToAddAfter !== false) {

            parent::addItemAfterItemByKey($field, $fieldToAddAfter->getKey(), $field->getKey());

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
    public function addBrickBeforeFieldByName(Brick $brick, string $fieldNameToAddBefore)
    {

        $this->prepareBrickForAdd($brick);

        $this->addFieldsBeforeFieldByName($brick->getFields(), $fieldNameToAddBefore);

        return $this;

    }

    /**
     * @param $new_field
     * @param $key_of_field_to_add_before
     * @return $this
     */
    public function addFieldBeforeFieldByKey($new_field, $key_of_field_to_add_before)
    {

        parent::addItemBeforeItemByKey($new_field, $key_of_field_to_add_before, $new_field->getKey());

        return $this;

    }

    /**
     * @param array $fields
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
    public function addFieldBeforeFieldByName(Field $field, $fieldNameToAddBefore)
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
     * @param Field $field
     * @return $this
     */
    public function addFieldToBeginning(Field $field)
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

            if ($field->getParentType() === 'brick' && $field->getParentKey() === $key) {
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
    public function removeBrickByName(string $name)
    {

        /** @var Field $field */
        foreach ($this->items AS $fieldKey => $field) {

            if ($field->getParentType() === 'brick' && $field->getParentName() === $name) {
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

        $found_field = false;

        /** @var Field $field */
        foreach($this->items AS $field) {

            if($field->getOriginalKey() === $key) {

                $found_field = $field;
                break;

            }

        }

        return $found_field;

    }

    /**
     * Set a string that will be prefixed to the labels of the fields that are added to this field group.
     *
     * @param $prefix
     * @return $this
     */
    public function setFieldLabelsPrefix($prefix)
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
    public function setFieldNamesPrefix($prefix)
    {

        $this->field_names_prefix = $prefix;

        return $this;

    }

    /**
     * @param $key_of_field_to_replace
     * @param $new_field
     * @return $this
     */
    public function replaceFieldByKey(Field $new_field, string $key_of_field_to_replace)
    {

        $this->addFieldBeforeFieldByKey($new_field, $key_of_field_to_replace);
        $this->removeFieldByKey($key_of_field_to_replace);

        return $this;

    }

    /**
     * @param $name_of_field_to_replace
     * @param $new_field
     * @return $this
     */
    public function replaceFieldByName(Field $new_field, string $name_of_field_to_replace)
    {

        $this->addFieldBeforeFieldByName($new_field, $name_of_field_to_replace);
        $this->removeFieldByName($name_of_field_to_replace);

        return $this;

    }

    protected function validateItem($item)
    {

        $valid = true;

        $this->validateKey($item->getKey(), $item);

        return $valid;

    }

    /**
     * @param string $key_prefix
     * @return array An array that ACF can work with.
     */
    public function toAcfArray(string $key_prefix = '')
    {

        $this->prepareForAcfArray();

        $acf_array = [];

        /** @var Field $field */
        foreach ($this->items AS $field) {

            $acf_array[] = $field->toAcfArray($key_prefix);

        }

        return $acf_array;

    }

}
