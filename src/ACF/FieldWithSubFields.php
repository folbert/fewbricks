<?php

namespace Fewbricks\ACF;

use Fewbricks\KeyInUseException;

/**
 * Class ItemWithSubFields
 *
 * @package Fewbricks\ACF
 */
class FieldWithSubFields extends Field
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

    }

    /**
     * @param Field $field
     *
     * @return $this
     */
    public function addField($field)
    {

        try {

            $this->fields->addItem($field, $field->getKey());

        } catch (KeyInUseException $keyInUseException) {

            $keyInUseException->wpDie();

        }

        return $this;

    }

    /**
     * @param $field
     * @param $fieldNameToAddAfter
     *
     * @return FieldWithSubFields
     */
    public function addFieldAfter($field, $fieldNameToAddAfter)
    {

        $this->fields->addFieldAfter($field, $fieldNameToAddAfter);

        return $this;

    }

    /**
     * @param $field
     * @param $fieldNameToAddBefore
     *
     * @return FieldWithSubFields
     */
    public function addFieldBefore($field, $fieldNameToAddBefore)
    {

        $this->fields->addFieldBefore($field, $fieldNameToAddBefore);

        return $this;

    }

    /**
     * @param array|FieldCollection $fields An array or an instance of FieldCollection.
     *
     * @return FieldWithSubFields
     * @throws KeyInUseException
     */
    public function addFields($fields)
    {

        $this->fields->addFields($fields);

        return $this;

    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function removeField($name)
    {

        $this->fields->removeItemByName($name);

        return $this;

    }

    /**
     * @return array
     */
    public function getAcfArray()
    {

        $settings = parent::getAcfArray();

        $settings['sub_fields'] = $this->fields->getAcfArray($this->key);

        return $settings;

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

}
