<?php

namespace Fewbricks\ACF;

use Fewbricks\Brick;

interface FieldCollectionInterface
{

    public function addBrick(Brick $brick);

    public function addBrickAfterByName(Brick $brick, string $fieldNameToAddAfter);

    public function addBrickBeforeByName(Brick $brick, string $fieldNameToAddBefore);

    public function addBrickToBeginning(Brick $brick);

    public function addField(Field $field);

    public function addFieldAfterByName(Field $field, string $fieldNameToAddAfter);

    public function addFieldBeforeByName(Field $field, string $fieldNameToAddBefore);

    public function addFieldCollection(FieldCollection $fieldCollection);

    public function addFieldSetting(string $fieldKey, string $settingsName, $settingsValue);

    public function addFieldToBeginning(Field $field);

    public function addFields($fields);

    public function addFieldsToBeginning($fields);

    public function removeBrickByKey(string $key);

    public function removeBrickByName(string $name);

    public function removeFieldByName(string $fieldName);

    public function removeFieldByKey(string $key);

    public function removeFieldsByName(array $fieldNames);

    public function removeFieldsByKey(array $keys);

}
