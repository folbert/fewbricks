<?php

namespace Fewbricks\ACF;

use Fewbricks\Brick;
use Fewbricks\KeyInUseException;

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
     *
     * @return FieldWithFields
     */
    public function addBrick(Brick $brick)
    {

        $this->fields->addBrick($brick);

        return $this;

    }

    /**
     * @param Field $field
     *
     * @return $this
     */
    public function addField(Field $field)
    {

        $this->fields->addField($field);

        return $this;

    }

    /**
     * @param Field $field
     * @param       $fieldNameToAddAfter
     *
     * @return FieldWithFields
     */
    public function addFieldAfter(Field $field, $fieldNameToAddAfter)
    {

        $this->fields->addFieldAfter($field, $fieldNameToAddAfter);

        return $this;

    }

    /**
     * @param Field $field
     * @param       $nameToAddAfter
     *
     * @return $this
     */
    public function addFieldAfterByName(Field $field, $nameToAddAfter) {

        $this->fields->addFieldAfterByName($field, $nameToAddAfter);

        return $this;

    }

    /**
     * @param Field $field
     * @param       $fieldNameToAddBefore
     *
     * @return FieldWithFields
     */
    public function addFieldBefore(Field $field, $fieldNameToAddBefore)
    {

        $this->fields->addFieldBefore($field, $fieldNameToAddBefore);

        return $this;

    }

    /**
     * @param Field $field
     * @param       $nameToAddBefore
     *
     * @return $this
     */
    public function addFieldBeforeByName(Field $field, $nameToAddBefore)
    {
        $this->fields->addFieldBeforeByName($field, $nameToAddBefore);

        return $this;

    }

    /**
     * @param FieldCollection $fieldCollection
     *
     * @return $this
     * @throws KeyInUseException
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
     *
     * @return FieldWithFields
     */
    public function addFieldSetting($fieldKey, $settingsName, $settingsValue)
    {

        $this->fields->addFieldSetting($fieldKey, $settingsName, $settingsValue);

        return $this;

    }


    /**
     * @param Field $field
     *
     * @return $this
     */
    public function addFieldToBeginning(Field $field)
    {

        $this->fields->addFieldToBeginning($field);

        return $this;

    }

    /**
     * @param FieldCollection|array $fields
     *
     * @return FieldWithFields
     * @throws KeyInUseException
     */
    public function addFields($fields)
    {

        $this->fields->addFields($fields);

        return $this;

    }

    /**
     * @param FieldCollection|array $fields
     *
     * @return $this
     */
    public function addFieldsToBeginning($fields)
    {

        $this->fields->addFieldsToBeginning($fields);

        return $this;

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
     * @param string $name
     *
     * @return $this
     */
    public function removeField($name)
    {

        $this->fields->removeField($name);

        return $this;

    }

    /**
     * @param string $key
     */
    public function removeFieldByKey($key)
    {

        $this->fields->removeFieldByKey($key);

    }

    /**
     * @param array $names
     */
    public function removeFields(array $names)
    {

        $this->fields->removeFields($names);

    }

    /**
     * @param array $keys
     */
    public function removeFieldsByKey(array $keys)
    {

        $this->fields->removeFieldsByKey($keys);

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

    /**
     * @param string $name
     */
    public function unRemoveField($name)
    {

        $this->fields->unRemoveField($name);

    }

    /**
     * @param string $key
     */
    public function unRemoveFieldByKey($key)
    {

        $this->fields->unRemoveFieldByKey($key);

    }

    /**
     * @param array $names
     */
    public function unRemoveFields(array $names)
    {

        $this->fields->unRemoveFields($names);

    }

    /**
     * @param array $keys
     */
    public function unRemoveFieldsByKey(array $keys)
    {

        $this->fields->unRemoveFieldsByKey($keys);

    }

}
