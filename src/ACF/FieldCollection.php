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
    public function add_brick($brick)
    {

        $this->prepare_brick_for_add($brick);
        $this->add_fields($brick->get_fields());

        return $this;

    }

    /**
     * @return string
     */
    public function get_key()
    {

        return $this->key;

    }

    /**
     * @param Brick $brick
     */
    private function prepare_brick_for_add(&$brick)
    {

        $brick->set_up();
        $brick->prepare_for_acf_array();

    }

    /**
     * @param FieldCollection|array $fields
     * @return $this
     */
    public function add_fields($fields)
    {

        if (is_array($fields)) {

            foreach ($fields AS $field) {

                $this->add_field($field);

            }

        } else if ($fields instanceof FieldCollection) {

            $this->add_field_collection($fields);

        }

        return $this;

    }

    /**
     * @return mixed
     */
    public function get_fields()
    {

        return $this->get_items();

    }

    /**
     * Prepares all fields in the collection for being transformed to an array. This must be called before creating
     * an ACF array and should be called just before doing so.
     */
    protected function prepare_for_acf_array()
    {

        if (!$this->preparedForAcfArray) {

            /** @var Field $field */
            foreach ($this->items AS &$field) {

                $field->prefix_name($this->fieldNamesPrefix);
                $field->prefix_label($this->fieldLabelsPrefix);
                $field->suffix_label($this->fieldLabelsSuffix);

            }

        }

        $this->preparedForAcfArray = true;

    }

    /**
     * @param Field $field
     * @return $this
     */
    public function add_field($field)
    {

        parent::add_item($field, $field->get_key());

        return $this;

    }

    /**
     * @param FieldCollection $fieldCollection
     * @return $this
     */
    public function add_field_collection($fieldCollection)
    {

        $fieldCollection->prepare_for_acf_array();

        $this->add_fields($fieldCollection->get_fields());

        return $this;

    }

    /**
     * @param Brick $brick
     * @param string $fieldNameToAddAfter
     * @return $this
     */
    public function add_brick_after_field_by_name($brick, string $fieldNameToAddAfter)
    {

        $this->prepare_brick_for_add($brick);

        $this->addFieldsAfterFieldByName($brick->get_fields(), $fieldNameToAddAfter);

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

            $this->add_field_after_field_by_name($field, $fieldNameToAddAfter);

        }

        return $this;

    }

    /**
     * @param Field $field
     * @param string $fieldNameToAddAfter
     * @return $this
     */
    public function add_field_after_field_by_name($field, string $fieldNameToAddAfter)
    {

        /** @var Field $fieldToAddAfter */
        $fieldToAddAfter = $this->get_field_by_name($fieldNameToAddAfter);

        if ($fieldToAddAfter !== false) {

            parent::add_item_after_item_by_key($field, $fieldToAddAfter->get_key(), $field->get_key());

        }

        return $this;

    }

    /**
     * @param string $nameToSearchFor
     * @return bool|mixed
     */
    public function get_field_by_name(string $nameToSearchFor)
    {

        $field = false;

        /**
         * @var string $itemKey
         * @var Field $possibleField
         */
        foreach ($this->items AS $possibleField) {

            if ($possibleField->get_final_name() === $nameToSearchFor) {

                $field = parent::get_item_by_key($possibleField->get_key());
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
    public function add_brick_before_field_by_name($brick, string $fieldNameToAddBefore)
    {

        $this->prepare_brick_for_add($brick);

        $this->add_fields_before_field_by_name($brick->get_fields(), $fieldNameToAddBefore);

        return $this;

    }

    /**
     * @param Field $new_field
     * @param string $key_of_field_to_add_before
     * @return $this
     */
    public function add_field_before_field_by_key($new_field, string $key_of_field_to_add_before)
    {

        parent::add_item_before_item_by_key($new_field, $key_of_field_to_add_before, $new_field->get_key());

        return $this;

    }

    /**
     * @param Field[] $fields
     * @param string $fieldNameToAddBefore
     * @return $this
     */
    public function add_fields_before_field_by_name(array $fields, string $fieldNameToAddBefore)
    {

        foreach ($fields AS $field) {

            $this->add_field_before_field_by_name($field, $fieldNameToAddBefore);

        }

        return $this;

    }

    /**
     * @param Field $field
     * @param string $fieldNameToAddBefore
     * @return $this
     */
    public function add_field_before_field_by_name($field, string $fieldNameToAddBefore)
    {

        /** @var Field $itemToAddAfter */
        $fieldToAddBefore = $this->get_field_by_name($fieldNameToAddBefore);

        if ($fieldToAddBefore !== false) {

            parent::add_item_before_item_by_key($field, $fieldToAddBefore->get_key(), $field->get_key());

        }

        return $this;

    }

    /**
     * @param Brick $brick
     * @return $this
     */
    public function add_brick_to_beginning($brick)
    {

        $this->prepare_brick_for_add($brick);

        // Since we wil be using addFields, lets reverse fields order to make sure they are added in the correct order
        $this->add_fields_to_beginning($brick->get_fields());

        return $this;

    }

    /**
     * @param FieldCollection|array $fields
     * @return $this
     */
    public function add_fields_to_beginning($fields)
    {

        if (is_array($fields)) {

            $keyedFields = [];

            /** @var Field $field */
            foreach ($fields AS $field) {

                $keyedFields[$field->get_key()] = $field;

            }

            $this->add_items_to_beginning($keyedFields);

        } else if ($fields instanceof FieldCollection) {

            $this->add_field_collection_to_beginning($fields);

        }

        return $this;

    }

    /**
     * @param FieldCollection $fieldCollection
     * @return $this
     */
    public function add_field_collection_to_beginning($fieldCollection)
    {

        $fieldCollection->prepare_for_acf_array();

        $this->add_fields_to_beginning($fieldCollection->get_items());

        return $this;

    }

    /**
     * @param Field $field
     * @return $this
     */
    public function add_field_to_beginning($field)
    {

        $this->add_item_to_beginning($field, $field->get_key());

        return $this;

    }

    /**
     * @param string $argument_name
     * @param null $default_value Value to return if arg is not set
     *
     * @return mixed|null
     */
    public function get_argument(string $argument_name, $default_value = null)
    {

        return (isset($this->arguments[$argument_name]) ? $this->arguments[$argument_name] : $default_value);

    }

    /**
     * Removes all fields that came from the brick with the passed key.
     *
     * @param string $key
     * @return $this
     */
    public function remove_brick_by_key(string $key)
    {

        /** @var Field $field */
        foreach ($this->items AS $fieldKey => $field) {

            foreach($field->get_parents() AS $parentData) {

                if ($parentData['type'] === Brick::CLASS_ID_STRING && $parentData['key'] === $key) {
                    $this->remove_item($fieldKey);
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
    public function remove_brick_by_name(string $name)
    {

        /** @var Field $field */
        foreach ($this->items AS $fieldKey => $field) {

            foreach($field->get_parents() AS $parentData) {

                if ($parentData['type'] === Brick::CLASS_ID_STRING && $parentData['name'] === $name) {
                    $this->remove_item($fieldKey);
                }

            }

        }

        return $this;

    }

    /**
     * @param array $keys
     * @return $this
     */
    public function remove_fields_by_key(array $keys)
    {

        foreach ($keys AS $key) {

            $this->remove_field_by_key($key);

        }

        return $this;

    }

    /**
     * @param string $key
     * @return $this
     */
    public function remove_field_by_key(string $key)
    {

        $this->remove_item($key);

        return $this;

    }

    /**
     * Remove a bunch of fields in one function call. Utilizes the function removeField. Note that the actual removal
     * of the field does not take place until the collection is finalized.
     *
     * @param array $fieldNames Array of names of fields to remove.
     * @return $this
     */
    public function remove_fields_by_name(array $fieldNames)
    {

        foreach ($fieldNames AS $fieldName) {

            $this->remove_field_by_name($fieldName);

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
    public function remove_field_by_name(string $fieldName)
    {

        /** @var Field $field */
        foreach ($this->items AS $itemKey => $field) {

            if ($field->get_name() === $fieldName) {

                parent::remove_item($itemKey);

            }

        }

        return $this;

    }

    /**
     * @param array $arguments
     * @return $this
     */
    public function add_arguments(array $arguments)
    {

        foreach ($arguments as $name => $value) {

            $this->add_argument($name, $value);

        }

        return $this;

    }

    /**
     * @param string $name
     * @param mixed $value
     * @return $this
     */
    public function add_argument(string $name, $value)
    {

        $this->arguments[$name] = $value;

        return $this;

    }

    /**
     * @param string $key
     * @return Field|bool
     */
    public function get_field_by_original_key_from_objects(string $key) {

        $foundField = false;

        /** @var Field $field */
        foreach($this->items AS $field) {

            if($field->get_original_key() === $key) {

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
    public function set_field_labels_prefix(string $prefix)
    {

        $this->fieldLabelsPrefix = $prefix;

        return $this;

    }

    /**
     * Set a string that will be suffixed to the labels of the fields that are added to this field group.
     *
     * @param $suffix
     * @return $this
     */
    public function set_field_labels_suffix(string $suffix)
    {

        $this->fieldLabelsSuffix = $suffix;

        return $this;

    }

    /**
     * Set a string that will be prefixed to the names of the fields that are added to this field group.
     *
     * @param string $prefix
     * @return $this
     */
    public function set_field_names_prefix(string $prefix)
    {

        $this->fieldNamesPrefix = $prefix;

        return $this;

    }

    /**
     * @param $keyOfFieldToReplace
     * @param $newField
     * @return $this
     */
    public function replace_field_by_key($newField, string $keyOfFieldToReplace)
    {

        $this->add_field_before_field_by_key($newField, $keyOfFieldToReplace);
        $this->remove_field_by_key($keyOfFieldToReplace);

        return $this;

    }

    /**
     * @param $nameOfFieldToReplace
     * @param $newField
     * @return $this
     */
    public function replace_field_by_name($newField, string $nameOfFieldToReplace)
    {

        $this->add_field_before_field_by_name($newField, $nameOfFieldToReplace);
        $this->remove_field_by_name($nameOfFieldToReplace);

        return $this;

    }

    /**
     * @param string $keyPrefix
     * @return array An array that ACF can work with.
     */
    public function to_acf_array(string $keyPrefix = '')
    {

        $this->prepare_for_acf_array();

        $acfArray = [];

        /** @var Field $field */
        foreach ($this->items AS $field) {

            $acfArray[] = $field->to_acf_array($keyPrefix);

        }

        return $acfArray;

    }

    /**
     * @param $keyToSearchFor
     * @param $arrayKey
     * @param $item
     * @return bool
     */
    protected function key_search_match($keyToSearchFor, $arrayKey, $item) {

        return $item->get_key() === $keyToSearchFor;

    }

}
