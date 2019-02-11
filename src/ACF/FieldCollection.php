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

        if (!$this->prepared_for_acf_array) {

            /** @var Field $field */
            foreach ($this->items AS &$field) {

                $field->prefix_name($this->field_names_prefix);
                $field->prefix_label($this->field_labels_prefix);
                $field->suffix_label($this->field_labels_suffix);

            }

        }

        $this->prepared_for_acf_array = true;

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
     * @param FieldCollection $field_collection
     * @return $this
     */
    public function add_field_collection($field_collection)
    {

        $field_collection->prepare_for_acf_array();

        $this->add_fields($field_collection->get_fields());

        return $this;

    }

    /**
     * @param Brick $brick
     * @param string $field_name_to_add_after
     * @return $this
     */
    public function add_brick_after_field_by_name($brick, string $field_name_to_add_after)
    {

        $this->prepare_brick_for_add($brick);

        $this->addFieldsAfterFieldByName($brick->get_fields(), $field_name_to_add_after);

        return $this;

    }

    /**
     * @param array $fields
     * @param string $field_name_to_add_after
     * @return $this
     */
    public function addFieldsAfterFieldByName(array $fields, string $field_name_to_add_after)
    {

        // Reverse the array to add the fields in the desired order
        $fields = array_reverse($fields);

        foreach ($fields AS $field) {

            $this->add_field_after_field_by_name($field, $field_name_to_add_after);

        }

        return $this;

    }

    /**
     * @param Field $field
     * @param string $field_name_to_add_after
     * @return $this
     */
    public function add_field_after_field_by_name($field, string $field_name_to_add_after)
    {

        /** @var Field $field_to_add_after */
        $field_to_add_after = $this->get_field_by_name($field_name_to_add_after);

        if ($field_to_add_after !== false) {

            parent::add_item_after_item_by_key($field, $field_to_add_after->get_key(), $field->get_key());

        }

        return $this;

    }

    /**
     * @param string $name_to_search_for
     * @return bool|mixed
     */
    public function get_field_by_name(string $name_to_search_for)
    {

        $field = false;

        /**
         * @var string $itemKey
         * @var Field $possible_field
         */
        foreach ($this->items AS $possible_field) {

            if ($possible_field->get_final_name() === $name_to_search_for) {

                $field = parent::get_item_by_key($possible_field->get_key());
                break;

            }

        }

        return $field;

    }

    /**
     * @param Brick $brick
     * @param string $field_name_to_add_before
     * @return $this
     */
    public function add_brick_before_field_by_name($brick, string $field_name_to_add_before)
    {

        $this->prepare_brick_for_add($brick);

        $this->add_fields_before_field_by_name($brick->get_fields(), $field_name_to_add_before);

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
     * @param string $field_name_to_add_before
     * @return $this
     */
    public function add_fields_before_field_by_name(array $fields, string $field_name_to_add_before)
    {

        foreach ($fields AS $field) {

            $this->add_field_before_field_by_name($field, $field_name_to_add_before);

        }

        return $this;

    }

    /**
     * @param Field $field
     * @param string $field_name_to_add_before
     * @return $this
     */
    public function add_field_before_field_by_name($field, string $field_name_to_add_before)
    {

        /** @var Field $itemToAddAfter */
        $field_to_add_before = $this->get_field_by_name($field_name_to_add_before);

        if ($field_to_add_before !== false) {

            parent::add_item_before_item_by_key($field, $field_to_add_before->get_key(), $field->get_key());

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

            $keyed_fields = [];

            /** @var Field $field */
            foreach ($fields AS $field) {

                $keyed_fields[$field->get_key()] = $field;

            }

            $this->add_items_to_beginning($keyed_fields);

        } else if ($fields instanceof FieldCollection) {

            $this->add_field_collection_to_beginning($fields);

        }

        return $this;

    }

    /**
     * @param FieldCollection $field_collection
     * @return $this
     */
    public function add_field_collection_to_beginning($field_collection)
    {

        $field_collection->prepare_for_acf_array();

        $this->add_fields_to_beginning($field_collection->get_items());

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
     * @param string $argument_name
     * @param mixed $argument_value
     * @return FieldCollection
     */
    public function set_argument(string $argument_name, $argument_value)
    {

        $this->arguments[$argument_name] = $argument_value;
        return $this;

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
        foreach ($this->items AS $field_key => $field) {

            foreach ($field->get_parents() AS $parent_data) {

                if ($parent_data['type'] === Brick::CLASS_ID_STRING && $parent_data['key'] === $key) {
                    $this->remove_item($field_key);
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
        foreach ($this->items AS $field_key => $field) {

            foreach ($field->get_parents() AS $parent_data) {

                if ($parent_data['type'] === Brick::CLASS_ID_STRING && $parent_data['name'] === $name) {
                    $this->remove_item($field_key);
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
     * @param array $field_names Array of names of fields to remove.
     * @return $this
     */
    public function remove_fields_by_name(array $field_names)
    {

        foreach ($field_names AS $field_name) {

            $this->remove_field_by_name($field_name);

        }

        return $this;

    }

    /**
     * Removes a field from the collection. Note that the actual removal does not take place until the collection is
     * finalized.
     *
     * @param string $field_name The name of a field. Not the key, not the label, the name.
     * @return $this
     */
    public function remove_field_by_name(string $field_name)
    {

        /** @var Field $field */
        foreach ($this->items AS $itemKey => $field) {

            if ($field->get_name() === $field_name) {

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
    public function get_field_by_original_key_from_objects(string $key)
    {

        $found_field = false;

        /** @var Field $field */
        foreach ($this->items AS $field) {

            if ($field->get_original_key() === $key) {

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
    public function set_field_labels_prefix(string $prefix)
    {

        $this->field_labels_prefix = $prefix;

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

        $this->field_labels_suffix = $suffix;

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

        $this->field_names_prefix = $prefix;

        return $this;

    }

    /**
     * @param $key_of_field_to_replace
     * @param $new_field
     * @return $this
     */
    public function replace_field_by_key($new_field, string $key_of_field_to_replace)
    {

        $this->add_field_before_field_by_key($new_field, $key_of_field_to_replace);
        $this->remove_field_by_key($key_of_field_to_replace);

        return $this;

    }

    /**
     * @param $name_of_field_to_replace
     * @param $new_field
     * @return $this
     */
    public function replace_field_by_name($new_field, string $name_of_field_to_replace)
    {

        $this->add_field_before_field_by_name($new_field, $name_of_field_to_replace);
        $this->remove_field_by_name($name_of_field_to_replace);

        return $this;

    }

    /**
     * @param string $key_prefix
     * @return array An array that ACF can work with.
     */
    public function to_acf_array(string $key_prefix = '')
    {

        $this->prepare_for_acf_array();

        $acf_array = [];

        /** @var Field $field */
        foreach ($this->items AS $field) {

            $acf_array[] = $field->to_acf_array($key_prefix);

        }

        return $acf_array;

    }

    /**
     * @param $key_to_search_for
     * @param $array_key
     * @param $item
     * @return bool
     */
    protected function key_search_match($key_to_search_for, $array_key, $item)
    {

        return $item->get_key() === $key_to_search_for;

    }

}
