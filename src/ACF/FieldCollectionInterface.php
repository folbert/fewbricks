<?php

namespace Fewbricks\ACF;

use Fewbricks\Brick;

interface FieldCollectionInterface
{

    public function addBrick(Brick $brick);

    public function addBrickAfterFieldByName(Brick $brick, string $fieldNameToAddAfter);

    public function addBrickBeforeFieldByName(Brick $brick, string $fieldNameToAddBefore);

    public function addBrickToBeginning(Brick $brick);

    public function addField(Field $field);

    public function addFieldAfterFieldByName(Field $field, string $fieldNameToAddAfter);

    public function addFieldBeforeFieldByName(Field $field, string $fieldNameToAddBefore);

    public function addFieldCollection(FieldCollection $fieldCollection);

    public function addFieldToBeginning(Field $field);

    public function addFields($fields);

    public function addFieldsToBeginning($fields);

    public function removeBrickByKey(string $key);

    public function removeBrickByName(string $name);

    public function removeFieldByName(string $fieldName);

    public function removeFieldByKey(string $key);

    public function removeFieldsByName(array $fieldNames);

    public function removeFieldsByKey(array $keys);

    public function replaceFieldByKey(Field $new_field, string $key_of_field_to_replace);

    public function replaceFieldByName(Field $new_field, string $name_of_field_to_replace);

}
