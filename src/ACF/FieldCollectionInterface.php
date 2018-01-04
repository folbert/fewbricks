<?php

namespace Fewbricks\ACF;

use Fewbricks\Brick;

interface FieldCollectionInterface
{

    public function addBrick(Brick $brick);

    public function addField(Field $field);

    public function addFieldAfter(Field $field, $fieldNameToAddAfter);

    public function addFieldBefore(Field $field, $fieldNameToAddBefore);

    public function addFieldCollection(FieldCollection $fieldCollection);

    public function addFieldSetting($fieldKey, $settingsName, $settingsValue);

    public function addFieldToBeginning(Field $field);

    public function addFields($fields);

    public function addFieldsToBeginning($fields);

    public function removeField($fieldName);

    public function removeFieldByKey($key);

    public function removeFields(array $fieldNames);

    public function removeFieldsByKey(array $keys);

    public function unRemoveField($fieldName);

    public function unRemoveFieldByKey($key);

    public function unRemoveFields(array $fieldNames);

    public function unRemoveFieldsByKey(array $keys);

}
