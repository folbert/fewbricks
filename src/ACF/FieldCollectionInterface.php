<?php

namespace Fewbricks\ACF;

use Fewbricks\ACF\Fields\Layout;
use Fewbricks\ACF\Fields\Repeater;
use Fewbricks\Brick;

interface FieldCollectionInterface
{

    public function add_brick(Brick $brick);

    public function add_brick_after_field_by_name(Brick $brick, string $field_name_to_add_after);

    public function add_brick_before_field_by_name(Brick $brick, string $field_name_to_add_before);

    public function add_brick_to_beginning(Brick $brick);

    public function add_field(Field $field);

    public function add_field_after_field_by_name(Field $field, string $field_name_to_add_after);

    public function add_field_before_field_by_name(Field $field, string $field_name_to_add_before);

    public function add_field_collection(FieldCollection $field_collection);

    public function add_field_to_beginning(Field $field);

    public function add_fields($fields);

    public function add_fields_to_beginning($fields);

    public function remove_brick_by_key(string $key);

    public function remove_brick_by_name(string $name);

    public function remove_field_by_name(string $field_name);

    public function remove_field_by_key(string $key);

    public function remove_fields_by_name(array $field_names);

    public function remove_fields_by_key(array $keys);

    public function replace_field_by_key(Field $new_field, string $key_of_field_to_replace);

    public function replace_field_by_name(Field $new_field, string $name_of_field_to_replace);

}
