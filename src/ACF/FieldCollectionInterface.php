<?php

namespace Fewbricks\ACF;

use Fewbricks\Brick;

interface FieldCollectionInterface
{

    public function add_brick($brick);

    public function add_brick_after_field_by_name($brick, string $fieldNameToAddAfter);

    public function add_brick_before_field_by_name($brick, string $fieldNameToAddBefore);

    public function add_brick_to_beginning($brick);

    public function add_field($field);

    public function add_field_after_field_by_name($field, string $fieldNameToAddAfter);

    public function add_field_before_field_by_name($field, string $fieldNameToAddBefore);

    public function add_field_collection($fieldCollection);

    public function add_field_to_beginning($field);

    public function add_fields($fields);

    public function add_fields_to_beginning($fields);

    public function remove_brick_by_key(string $key);

    public function remove_brick_by_name(string $name);

    public function remove_field_by_name(string $fieldName);

    public function remove_field_by_key(string $key);

    public function remove_fields_by_name(array $fieldNames);

    public function remove_fields_by_key(array $keys);

    public function replace_field_by_key($newField, string $keyOfFieldToReplace);

    public function replace_field_by_name($newField, string $nameOfFieldToReplace);

}
