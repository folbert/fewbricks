<?php

namespace Fewbricks\ACF;

use Fewbricks\Brick;

interface FieldCollectionInterface
{

    public function add_brick($brick);

    public function add_brick_after_field_by_name($brick, string $field_name_to_add_after);

    public function add_brick_before_field_by_name($brick, string $field_name_to_add_before);

    public function add_brick_to_beginning($brick);

    public function add_field($field);

    public function add_field_after_field_by_name($field, string $field_name_to_add_after);

    public function add_field_before_field_by_name($field, string $field_name_to_add_before);

    public function add_field_collection($field_collection);

    public function add_field_to_beginning($field);

    public function add_fields($fields);

    public function add_fields_to_beginning($fields);

    public function remove_brick_by_key(string $key);

    public function remove_brick_by_name(string $name);

    public function remove_field_by_name(string $field_name);

    public function remove_field_by_key(string $key);

    public function remove_fields_by_name(array $field_names);

    public function remove_fields_by_key(array $keys);

    public function replace_field_by_key($new_field, string $key_of_field_to_replace);

    public function replace_field_by_name($new_field, string $name_of_field_to_replace);

}
