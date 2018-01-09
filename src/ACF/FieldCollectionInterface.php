<?php

namespace Fewbricks\ACF;

use Fewbricks\Brick;

interface FieldCollectionInterface
{

    public function addBrick(Brick $brick);

    public function addBrickAfterByName(Brick $brick, $fieldNameToAddAfter);

    public function addBrickBeforeByName(Brick $brick, $fieldNameToAddBefore);

    public function addBrickToBeginning(Brick $brick);

    public function addField(Field $field);

    public function addFieldAfterByName(Field $field, $fieldNameToAddAfter);

    public function addFieldBeforeByName(Field $field, $fieldNameToAddBefore);

    public function addFieldCollection(FieldCollection $fieldCollection);

    public function addFieldSetting($fieldKey, $settingsName, $settingsValue);

    public function addFieldToBeginning(Field $field);

    public function addFields($fields);

    public function addFieldsToBeginning($fields);

    public function removeBrickByKey($key);

    public function removeBrickByName($name);

    public function removeFieldByName($fieldName);

    public function removeFieldByKey($key);

    public function removeFieldsByName(array $fieldNames);

    public function removeFieldsByKey(array $keys);

}
