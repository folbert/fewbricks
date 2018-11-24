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
     * @param array  $settings
     */
    public function __construct(
        $label,
        $name,
        $key,
        array $settings = []
    ) {

        parent::__construct($label, $name, $key, $settings);

        $this->fields = new FieldCollection();
        $this->fields->setBaseKey($key);

    }

    /**
     * @param Brick $brick
     */
    public function addBrick(Brick $brick)
    {

        $this->fields->addBrick($brick);

    }

    /**
     * @param Brick  $brick
     * @param string $fieldNameToAddAfter
     */
    public function addBrickAfterByName(Brick $brick, string $fieldNameToAddAfter)
    {

        $this->fields->addBrickAfterByName($brick, $fieldNameToAddAfter);

    }

    /**
     * @param Brick  $brick
     * @param string $fieldNameToAddBefore
     */
    public function addBrickBeforeByName(Brick $brick, string $fieldNameToAddBefore)
    {

        $this->fields->addBrickBeforeByName($brick, $fieldNameToAddBefore);

    }

    /**
     * @param Brick $brick
     */
    public function addBrickToBeginning(Brick $brick)
    {

        $this->fields > $this->addBrickToBeginning($brick);

    }

    /**
     * @param Field $field
     */
    public function addField(Field $field)
    {

        $this->fields->addField($field);

    }

    /**
     * @param Field $field
     * @param       $fieldNameToAddAfter
     */
    public function addFieldAfterByName(Field $field, $fieldNameToAddAfter)
    {

        $this->fields->addFieldAfterByName($field, $fieldNameToAddAfter);

    }

    /**
     * @param Field $field
     * @param       $fieldNameToAddBefore
     */
    public function addFieldBeforeByName(Field $field, $fieldNameToAddBefore)
    {

        $this->fields->addFieldBeforeByName($field, $fieldNameToAddBefore);

    }

    /**
     * @param FieldCollection $fieldCollection
     */
    public function addFieldCollection(FieldCollection $fieldCollection)
    {

        $this->fields->addFieldCollection($fieldCollection);

    }

    /**
     * @param $fieldKey
     * @param $settingsName
     * @param $settingsValue
     */
    public function addFieldSetting($fieldKey, $settingsName, $settingsValue)
    {

        $this->fields->addFieldSetting($fieldKey, $settingsName, $settingsValue);

    }


    /**
     * @param Field $field
     */
    public function addFieldToBeginning(Field $field)
    {

        $this->fields->addFieldToBeginning($field);

    }

    /**
     * @param FieldCollection|array $fields
     */
    public function addFields($fields)
    {

        $this->fields->addFields($fields);

    }

    /**
     * @param FieldCollection|array $fields
     */
    public function addFieldsToBeginning($fields)
    {

        $this->fields->addFieldsToBeginning($fields);

    }

    /**
     * @param int $key
     *
     * @return mixed
     */
    public function getField($key)
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
     */
    public function removeBrickByKey($key)
    {

        $this->fields->removeBrickByKey($key);

    }

    /**
     * @param string $name
     */
    public function removeBrickByName($name)
    {

        $this->fields->removeBrickByName($name);

    }

    /**
     * @param string $key
     */
    public function removeFieldByKey($key)
    {

        $this->fields->removeFieldByKey($key);

    }

    /**
     * @param string $name
     */
    public function removeFieldByName($name)
    {

        $this->fields->removeFieldByName($name);

    }

    /**
     * @param array $keys
     */
    public function removeFieldsByKey(array $keys)
    {

        $this->fields->removeFieldsByKey($keys);

    }

    /**
     * @param array $names
     */
    public function removeFieldsByName(array $names)
    {

        $this->fields->removeFieldsByName($names);

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
