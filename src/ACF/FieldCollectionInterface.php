<?php

namespace Fewbricks\ACF;

use Fewbricks\Brick;

interface FieldCollectionInterface
{

    public function addBrick($brick);

    public function addBrickAfterFieldByName($brick, string $fieldNameToAddAfter);

    public function addBrickBeforeFieldByName($brick, string $fieldNameToAddBefore);

    public function addBrickToBeginning($brick);

    public function addField($field);

    public function addFieldAfterFieldByName($field, string $fieldNameToAddAfter);

    public function addFieldBeforeFieldByName($field, string $fieldNameToAddBefore);

    public function addFieldCollection($fieldCollection);

    public function addFieldToBeginning($field);

    public function addFields($fields);

    public function addFieldsToBeginning($fields);

    public function removeBrickByKey(string $key);

    public function removeBrickByName(string $name);

    public function removeFieldByName(string $fieldName);

    public function removeFieldByKey(string $key);

    public function removeFieldsByName(array $fieldNames);

    public function removeFieldsByKey(array $keys);

    public function replaceFieldByKey($newField, string $keyOfFieldToReplace);

    public function replaceFieldByName($newField, string $nameOfFieldToReplace);

}
