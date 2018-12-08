<?php

namespace Fewbricks\ACF;

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
     * @param string $label
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
    public function addBrick($brick)
    {

        $this->fields->addBrick($brick);

        return $this;

    }

    /**
     * @param Brick $brick
     * @param string $fieldNameToAddAfter
     * @return $this
     */
    public function addBrickAfterFieldByName($brick, string $fieldNameToAddAfter)
    {

        $this->fields->addBrickAfterFieldByName($brick, $fieldNameToAddAfter);

        return $this;

    }

    /**
     * @param Brick $brick
     * @param string $fieldNameToAddBefore
     * @return $this
     */
    public function addBrickBeforeFieldByName($brick, string $fieldNameToAddBefore)
    {

        $this->fields->addBrickBeforeFieldByName($brick, $fieldNameToAddBefore);

        return $this;

    }

    /**
     * @param Brick $brick
     * @return $this
     */
    public function addBrickToBeginning($brick)
    {

        $this->fields->addBrickToBeginning($brick);

        return $this;

    }

    /**
     * @param Field $field
     * @return $this
     */
    public function addField($field)
    {

        $this->fields->addField($field);

        return $this;

    }

    /**
     * @param Field $field
     * @param string $fieldNameToAddAfter
     * @return $this
     */
    public function addFieldAfterFieldByName($field, string $fieldNameToAddAfter)
    {

        $this->fields->addFieldAfterFieldByName($field, $fieldNameToAddAfter);

        return $this;

    }

    /**
     * @param Field $field
     * @param string $fieldNameToAddBefore
     * @return $this
     */
    public function addFieldBeforeFieldByName($field, string $fieldNameToAddBefore)
    {

        $this->fields->addFieldBeforeFieldByName($field, $fieldNameToAddBefore);

        return $this;

    }

    /**
     * @param FieldCollection $fieldCollection
     * @return $this
     */
    public function addFieldCollection($fieldCollection)
    {

        $this->fields->addFieldCollection($fieldCollection);

        return $this;

    }


    /**
     * @param Field $field
     * @return $this
     */
    public function addFieldToBeginning($field)
    {

        $this->fields->addFieldToBeginning($field);

        return $this;

    }

    /**
     * @param FieldCollection|Field[] $fields
     * @return $this
     */
    public function addFields($fields)
    {

        $this->fields->addFields($fields);

        return $this;

    }

    /**
     * @param FieldCollection|Field[] $fields
     * @return $this
     */
    public function addFieldsToBeginning($fields)
    {

        $this->fields->addFieldsToBeginning($fields);

        return $this;

    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function getField(string $key)
    {

        return $this->fields->getItemByKey($key);

    }

    /**
     * @return FieldCollection
     */
    public function getFields()
    {

        return $this->fields;

    }

    /**
     * @param string $key
     * @return $this
     */
    public function removeBrickByKey(string $key)
    {

        $this->fields->removeBrickByKey($key);

        return $this;

    }

    /**
     * @param string $name
     * @return $this
     */
    public function removeBrickByName(string $name)
    {

        $this->fields->removeBrickByName($name);

        return $this;

    }

    /**
     * @param string $key
     * @return $this
     */
    public function removeFieldByKey(string $key)
    {

        $this->fields->removeFieldByKey($key);

        return $this;

    }

    /**
     * @param string $name
     * @return $this
     */
    public function removeFieldByName(string $name)
    {

        $this->fields->removeFieldByName($name);

        return $this;

    }

    /**
     * @param array $keys
     * @return $this
     */
    public function removeFieldsByKey(array $keys)
    {

        $this->fields->removeFieldsByKey($keys);

        return $this;

    }

    /**
     * @param array $names
     * @return $this
     */
    public function removeFieldsByName(array $names)
    {

        $this->fields->removeFieldsByName($names);

        return $this;

    }

    /**
     * @param Field $newField
     * @param string $keyOfFieldToReplace
     * @return $this
     */
    public function replaceFieldByKey($newField, string $keyOfFieldToReplace)
    {

        $this->fields->replaceFieldByKey($newField, $keyOfFieldToReplace);

        return $this;

    }

    /**
     * @param Field $newField
     * @param string $nameOfFieldToReplace
     * @return $this
     */
    public function replaceFieldByName($newField, string $nameOfFieldToReplace)
    {

        $this->fields->replaceFieldByName($newField, $nameOfFieldToReplace);

        return $this;

    }

    /**
     * @param string $keyPrefix
     * @return array
     */
    public function toAcfArray(string $keyPrefix = '')
    {

        $settings = parent::toAcfArray($keyPrefix);

        $settings['sub_fields'] = $this->fields->toAcfArray($settings['key']);

        return $settings;

    }

}
