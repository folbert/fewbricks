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
     * @param array $settings
     */
    public function __construct(
        $label,
        $name,
        $key,
        array $settings = []
    )
    {

        parent::__construct($label, $name, $key, $settings);

        $this->fields = new FieldCollection();
        $this->fields->setBaseKey($key);

    }

    /**
     * @param Brick $brick
     * @return $this
     */
    public function addBrick(Brick $brick)
    {

        $this->fields->addBrick($brick);

        return $this;

    }

    /**
     * @param Brick $brick
     * @param string $fieldNameToAddAfter
     * @return $this
     */
    public function addBrickAfterByName(Brick $brick, string $fieldNameToAddAfter)
    {

        $this->fields->addBrickAfterByName($brick, $fieldNameToAddAfter);

        return $this;

    }

    /**
     * @param Brick $brick
     * @param string $fieldNameToAddBefore
     * @return $this
     */
    public function addBrickBeforeByName(Brick $brick, string $fieldNameToAddBefore)
    {

        $this->fields->addBrickBeforeByName($brick, $fieldNameToAddBefore);

        return $this;

    }

    /**
     * @param Brick $brick
     * @return $this
     */
    public function addBrickToBeginning(Brick $brick)
    {

        $this->fields->addBrickToBeginning($brick);

        return $this;

    }

    /**
     * @param Field $field
     * @return $this
     */
    public function addField(Field $field)
    {

        $this->fields->addField($field);

        return $this;

    }

    /**
     * @param Field $field
     * @param string $fieldNameToAddAfter
     * @return $this
     */
    public function addFieldAfterByName(Field $field, string $fieldNameToAddAfter)
    {

        $this->fields->addFieldAfterByName($field, $fieldNameToAddAfter);

        return $this;

    }

    /**
     * @param Field $field
     * @param string $fieldNameToAddBefore
     * @return $this
     */
    public function addFieldBeforeByName(Field $field, string $fieldNameToAddBefore)
    {

        $this->fields->addFieldBeforeByName($field, $fieldNameToAddBefore);

        return $this;

    }

    /**
     * @param FieldCollection $fieldCollection
     * @return $this
     */
    public function addFieldCollection(FieldCollection $fieldCollection)
    {

        $this->fields->addFieldCollection($fieldCollection);

        return $this;

    }

    /**
     * @param $fieldKey
     * @param $settingsName
     * @param $settingsValue
     * @return $this
     */
    public function addFieldSetting(string $fieldKey, string $settingsName, string $settingsValue)
    {

        $this->fields->addFieldSetting($fieldKey, $settingsName, $settingsValue);

        return $this;

    }


    /**
     * @param Field $field
     * @return $this
     */
    public function addFieldToBeginning(Field $field)
    {

        $this->fields->addFieldToBeginning($field);

        return $this;

    }

    /**
     * @param FieldCollection|array $fields
     * @return $this
     */
    public function addFields($fields)
    {

        $this->fields->addFields($fields);

        return $this;

    }

    /**
     * @param FieldCollection|array $fields
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

        return $this->fields->getItem($key);

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
    public function removeBrickByKey($key)
    {

        $this->fields->removeBrickByKey($key);

        return $this;

    }

    /**
     * @param string $name
     * @return $this
     */
    public function removeBrickByName($name)
    {

        $this->fields->removeBrickByName($name);

        return $this;

    }

    /**
     * @param string $key
     * @return $this
     */
    public function removeFieldByKey($key)
    {

        $this->fields->removeFieldByKey($key);

        return $this;

    }

    /**
     * @param string $name
     * @return $this
     */
    public function removeFieldByName($name)
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
     * @param array $extraSettings Any extra settings that you want to apply at the last minute. Be careful not to set
     *                             crucial settings like "key" and "conditional_logic" here. We will not remove any
     *                             such items from the array in case you really want to set them,
     *
     * @return array
     */
    public function toAcfArray(array $extraSettings = [])
    {

        $settings = parent::toAcfArray($extraSettings);

        $settings['sub_fields'] = $this->fields->toAcfArray();

        return $settings;

    }

}
