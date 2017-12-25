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
    protected $subFields;

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

        $this->subFields = new FieldCollection();

    }

    /**
     * @param Field $field
     *
     * @return $this
     */
    public function addSubField($field)
    {

        try {

            $this->subFields->addItem($field, $field->getKey());

        } catch(KeyInUseException $keyInUseException) {

            $keyInUseException->wpDie();

        }

        return $this;

    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function removeSubField($name)
    {

        $this->subFields->removeItemByName($name);

        return $this;

    }

    /**
     * @return array
     */
    public function toAcfArray()
    {

        $settings = parent::toAcfArray();

        $settings['sub_fields'] = $this->subFields->toArray($this->key);

        return $settings;

    }

    /**
     * @param int $key
     *
     * @return mixed
     */
    public function getSubField($key)
    {

        return $this->subFields->getItem($key);

    }

    /**
     * @return FieldCollection
     */
    public function getSubFields()
    {

        return $this->subFields;

    }

}
