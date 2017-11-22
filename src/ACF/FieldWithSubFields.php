<?php

namespace Fewbricks\ACF;

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
     * @param string $type
     * @param string $label
     * @param string $name
     * @param string $key
     * @param array  $settings
     */
    public function __construct(
        $type,
        $label,
        $name,
        $key,
        array $settings = []
    ) {

        parent::__construct($type, $label, $name, $key, $settings);

        $this->subFields = new FieldCollection();

    }

    /**
     * @param Field $field
     * @param null $key
     */
    public function addSubField($field, $key = null)
    {

        $this->subFields->addItem($field, $key);

    }

    /**
     * @param int $key
     */
    public function deleteSubField($key)
    {

        $this->subFields->deleteItem($key);

    }

    /**
     * @return array
     */
    public function getSettings()
    {

        $settings = parent::getSettings();

        $settings['sub_fields'] = $this->subFields->getFinalizedSettings($this->key);

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
