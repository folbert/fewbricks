<?php

namespace Fewbricks\ACF;

use Fewbricks\ACF\Fields\Layout;
use Fewbricks\Brick;

/**
 * Class ItemWithSubFields
 *
 * @package Fewbricks\ACF
 */
class FieldWithFields extends Field implements FieldCollectionInterface
{

    /**
     * @var FieldCollection
     */
    protected $fields;

    /**
     * FieldWithSubFields constructor.
     *
     * @param string|boolean $label
     * @param string $name
     * @param string $key
     */
    public function __construct($label, $name, $key)
    {

        parent::__construct($label, $name, $key);

        $this->fields = new SubFieldCollection($key);

    }

    /**
     * @param Brick $brick
     * @return $this
     */
    public function add_brick($brick)
    {

        $this->fields->add_brick($brick);

        if($this->label === false) {
            $this->label = $brick->get_label();
        }

        return $this;

    }

    /**
     * @param Brick $brick
     * @param string $field_name_to_add_after
     * @return $this
     */
    public function add_brick_after_field_by_name($brick, string $field_name_to_add_after)
    {

        $this->fields->add_brick_after_field_by_name($brick, $field_name_to_add_after);

        return $this;

    }

    /**
     * @param Brick $brick
     * @param string $field_name_to_add_before
     * @return $this
     */
    public function add_brick_before_field_by_name($brick, string $field_name_to_add_before)
    {

        $this->fields->add_brick_before_field_by_name($brick, $field_name_to_add_before);

        return $this;

    }

    /**
     * @param Brick $brick
     * @return $this
     */
    public function add_brick_to_beginning($brick)
    {

        $this->fields->add_brick_to_beginning($brick);

        return $this;

    }

    /**
     * @param Field $field
     * @return $this
     */
    public function add_field($field)
    {

        $this->fields->add_field($field);

        return $this;

    }

    /**
     * @param Field $field
     * @param string $field_name_to_add_after
     * @return $this
     */
    public function add_field_after_field_by_name($field, string $field_name_to_add_after)
    {

        $this->fields->add_field_after_field_by_name($field, $field_name_to_add_after);

        return $this;

    }

    /**
     * @param Field $field
     * @param string $field_name_to_add_before
     * @return $this
     */
    public function add_field_before_field_by_name($field, string $field_name_to_add_before)
    {

        $this->fields->add_field_before_field_by_name($field, $field_name_to_add_before);

        return $this;

    }

    /**
     * @param FieldCollection $field_collection
     * @return $this
     */
    public function add_field_collection($field_collection)
    {

        $this->fields->add_field_collection($field_collection);

        return $this;

    }


    /**
     * @param Field $field
     * @return $this
     */
    public function add_field_to_beginning($field)
    {

        $this->fields->add_field_to_beginning($field);

        return $this;

    }

    /**
     * @param FieldCollection|Field[] $fields
     * @return $this
     */
    public function add_fields($fields)
    {

        $this->fields->add_fields($fields);

        return $this;

    }

    /**
     * @param FieldCollection|Field[] $fields
     * @return $this
     */
    public function add_fields_to_beginning($fields)
    {

        $this->fields->add_fields_to_beginning($fields);

        return $this;

    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function get_field(string $key)
    {

        return $this->fields->get_item_by_key($key);

    }

    /**
     * @return FieldCollection
     */
    public function get_fields()
    {

        return $this->fields;

    }

    /**
     * @param string $key
     * @return $this
     */
    public function remove_brick_by_key(string $key)
    {

        $this->fields->remove_brick_by_key($key);

        return $this;

    }

    /**
     * @param string $name
     * @return $this
     */
    public function remove_brick_by_name(string $name)
    {

        $this->fields->remove_brick_by_name($name);

        return $this;

    }

    /**
     * @param string $key
     * @return $this
     */
    public function remove_field_by_key(string $key)
    {

        $this->fields->remove_field_by_key($key);

        return $this;

    }

    /**
     * @param string $name
     * @return $this
     */
    public function remove_field_by_name(string $name)
    {

        $this->fields->remove_field_by_name($name);

        return $this;

    }

    /**
     * @param array $keys
     * @return $this
     */
    public function remove_fields_by_key(array $keys)
    {

        $this->fields->remove_fields_by_key($keys);

        return $this;

    }

    /**
     * @param array $names
     * @return $this
     */
    public function remove_fields_by_name(array $names)
    {

        $this->fields->remove_fields_by_name($names);

        return $this;

    }

    /**
     * @param Field $new_field
     * @param string $key_of_field_to_replace
     * @return $this
     */
    public function replace_field_by_key(Field $new_field, string $key_of_field_to_replace)
    {

        $this->fields->replace_field_by_key($new_field, $key_of_field_to_replace);

        return $this;

    }

    /**
     * @param Field $new_field
     * @param string $name_of_field_to_replace
     * @return $this
     */
    public function replace_field_by_name(Field $new_field, string $name_of_field_to_replace)
    {

        $this->fields->replace_field_by_name($new_field, $name_of_field_to_replace);

        return $this;

    }

    /**
     * @param string $key_prefix
     * @return array
     */
    public function to_acf_array(string $key_prefix = '')
    {

        $settings = parent::to_acf_array($key_prefix);

        $settings['sub_fields'] = $this->fields->to_acf_array($settings['key']);

        return $settings;

    }

}
