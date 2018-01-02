<?php

namespace Fewbricks\ACF;

use Fewbricks\Brick;
use Fewbricks\Collection;

/**
 * Class FieldCollection
 *
 * @package Fewbricks\ACF
 */
class FieldCollection extends Collection
{

    /**
     * @var array
     */
    protected $args;

    /**
     * @var string
     */
    protected $baseKey;

    /**
     * @var string
     */
    private $fieldLabelsPrefix;

    /**
     * @var string
     */
    private $fieldLabelsSuffix;

    /**
     * @var string
     */
    private $fieldNamesPrefix;

    /**
     * @var array
     */
    private $fieldsSettings;

    /**
     * @var array
     */
    private $fieldsToRemove;

    /**
     * @var array
     */
    private $fieldsToRemoveByKey;

    /**
     * @var array
     */
    private $fieldsToAddAfterFieldsOnBuild;

    /**
     * @var array
     */
    private $fieldsToAddBeforeFieldsOnBuild;

    /**
     * @var boolean
     */
    private $preparedForAcfArray;

    /**
     * FieldCollection constructor.
     *
     * @param array $args
     */
    public function __construct($args = [])
    {

        if (!is_array($args)) {
            $args = [];
        }

        $this->args = $args;

        $this->fieldNamesPrefix               = '';
        $this->fieldLabelsPrefix              = '';
        $this->fieldLabelsSuffix              = '';
        $this->fieldsToRemove                 = [];
        $this->fieldsToRemoveByKey            = [];
        $this->fieldsToAddAfterFieldsOnBuild  = [];
        $this->fieldsToAddBeforeFieldsOnBuild = [];
        $this->fieldsSettings                 = [];

        $this->preparedForAcfArray = false;

        parent::__construct();

    }

    /**
     * @param Brick $brick
     *
     * @return $this
     * @throws \Fewbricks\KeyInUseException
     */
    public function addBrick($brick)
    {

        $brick->setFields();
        $brick->prepareForAcfArray();

        /** @var Field $field */
        foreach ($brick->getFields() AS $field) {

            $this->addField($field);

        }

        return $this;

    }

    /**
     * @param Field $field
     *
     * @return $this
     * @throws \Fewbricks\KeyInUseException
     */
    public function addField($field)
    {

        try {

            parent::addItem($field, $field->getKey());

        } catch (KeyInUseException $keyInUseException) {

            $keyInUseException->wpDie();

        }

        return $this;

    }

    /**
     * @param Field  $field
     * @param string $fieldNameToAddAfter
     *
     * @return FieldGroup
     */
    public function addFieldAfter($field, $fieldNameToAddAfter)
    {

        $this->fieldsToAddAfterFieldsOnBuild[] = [$field, $fieldNameToAddAfter];

        return $this;

    }

    /**
     * @param Field  $field
     * @param string $nameToAddAfter
     */
    public function addFieldAfterByName($field, $nameToAddAfter)
    {

        /** @var Field $fieldToAddAfter */
        $fieldToAddAfter = $this->getFieldByName($nameToAddAfter);

        if ($fieldToAddAfter !== false) {

            parent::addItemAfter($field, $fieldToAddAfter->getKey());

        }

    }

    /**
     * @param Field  $field
     * @param string $fieldNameToAddBefore
     *
     * @return FieldGroup
     */
    public function addFieldBefore($field, $fieldNameToAddBefore)
    {

        $this->fieldsToAddBeforeFieldsOnBuild[] = [$field, $fieldNameToAddBefore];

        return $this;

    }

    /**
     * @param Field  $field
     * @param string $nameToAddBefore
     */
    public function addFieldBeforeByName($field, $nameToAddBefore)
    {

        /** @var Field $itemToAddAfter */
        $fieldToAddBefore = $this->getFieldByName($nameToAddBefore);

        if ($fieldToAddBefore !== false) {

            parent::addItemBefore($field, $fieldToAddBefore->getKey());

        }

    }

    /**
     * Set ACF settings on fields in this collection. The values will be applied as they are so don't use this to set
     * keys or conditional logic.
     *
     * @param array  $fieldKey      The original key (the one set when a field was created) of a field in this
     *                              collection..
     * @param string $settingsName  Should correspond to the name of an ACF setting
     * @param mixed  $settingsValue A valid value for the setting
     *
     * @return FieldCollection
     */
    public function addFieldSetting($fieldKey, $settingsName, $settingsValue)
    {

        if (!isset($this->fieldsSettings[$fieldKey])) {

            $this->fieldsSettings[$fieldKey] = [];

        }

        $this->fieldsSettings[$fieldKey][$settingsName] = $settingsValue;

        return $this;

    }

    /**
     * @param array|FieldCollection $fields
     *
     * @throws \Fewbricks\KeyInUseException
     */
    public function addFields($fields)
    {

        if (is_array($fields)) {

            foreach ($fields AS $field) {

                $this->addField($field);

            }

        } else {

            // Call same function again but this time with the array representation of the collection
            $this->addFields($fields->getFields());

        }

    }

    /**
     *
     */
    protected function doAddFieldsAfter()
    {

        foreach ($this->fieldsToAddAfterFieldsOnBuild AS $data) {

            $this->addFieldAfterByName($data[0], $data[1]);

        }

    }

    /**
     *
     */
    protected function doAddFieldsBefore()
    {

        foreach ($this->fieldsToAddBeforeFieldsOnBuild AS $data) {

            $this->addFieldBeforeByName($data[0], $data[1]);

        }

    }

    /**
     *
     */
    protected function doAddFieldsBefore()
    {

        foreach ($this->fieldsToAddBeforeFieldsOnBuild AS $data) {

            $this->addFieldBeforeByName($data[0], $data[1]);

        }

    }

    /**
     * @param $name
     */
    private function doRemoveFieldByName($name)
    {

        /** @var Field $field */
        foreach ($this->items AS $itemKey => $field) {

            if ($field->getName() === $name) {

                parent::removeItem($itemKey);

            }

        }

    }

    /**
     *
     */
    protected function doRemoveFields()
    {

        foreach ($this->fieldsToRemove AS $fieldToRemove) {

            $this->doRemoveFieldByName($fieldToRemove);

        }

        foreach ($this->fieldsToRemoveByKey AS $keyToRemove) {

            if (substr($keyToRemove, 0, 6) !== 'field_') {
                $keyToRemove = 'field_' . $keyToRemove;
            }

            $this->removeItem($keyToRemove);

        }

    }

    /**
     * @param string $name
     * @param null   $defaultValue Value to return if arg is not set
     *
     * @return mixed|null
     */
    public function getArg($name, $defaultValue = null)
    {

        return (isset($this->args[$name]) ? $this->args[$name] : $defaultValue);

    }

    /**
     * @return mixed
     */
    public function getBaseKey()
    {

        return $this->baseKey;

    }

    /**
     * @param string $baseKey
     */
    public function setBaseKey($baseKey)
    {

        $this->baseKey = $baseKey;

    }

    /**
     * @param $name
     *
     * @return bool|mixed
     */
    public function getFieldByName($name)
    {

        $field = false;

        /**
         * @var string $itemKey
         * @var Field  $field
         */
        foreach ($this->items AS $itemKey => $field) {

            if ($field->getName() === $name) {

                $field = parent::getItem($itemKey);

            }

        }

        return $field;

    }

    /**
     * @return mixed
     */
    public function getFields()
    {

        return $this->getItems();

    }

    /**
     * @param array $fieldsSettings
     *
     * @return mixed
     */
    private function prepareFieldsConditionalLogic($fieldsSettings)
    {

        foreach ($fieldsSettings AS $fieldSettingsKey => $fieldSettings) {

            // Do the field have conditional logic
            if (isset($fieldSettings['conditional_logic'])
                && is_array($fieldSettings['conditional_logic'])
            ) {

                $conditionalLogic = $fieldSettings['conditional_logic'];

                // Traverse down the conditional logic array
                foreach ($conditionalLogic AS $conditionalLogicGroupKey => $conditionalLogicGroupValue) {

                    foreach (
                        $conditionalLogic[$conditionalLogicGroupKey] AS $conditionalLogicItemKey =>
                        $conditionalLogicItemValue
                    ) {

                        $targetFieldKey
                            = $conditionalLogic[$conditionalLogicGroupKey][$conditionalLogicItemKey]['field'];

                        // Loop all other items in this collection
                        foreach ($this->items AS $otherFieldObject) {

                            if ($otherFieldObject->getOriginalKey() === $targetFieldKey) {

                                $conditionalLogic[$conditionalLogicGroupKey][$conditionalLogicItemKey]['field']
                                    = $otherFieldObject->getKey();

                            }

                        }

                    }

                }

                $fieldsSettings[$fieldSettingsKey]['conditional_logic'] = $conditionalLogic;

            }

        }

        return $fieldsSettings;

    }

    /**
     *
     */
    protected function prepareForAcfArray()
    {

        if (!$this->preparedForAcfArray) {

            $this->doRemoveFields();
            $this->doAddFieldsAfter();
            $this->doAddFieldsBefore();

            /** @var Field $field */
            foreach ($this->items AS &$field) {

                $field->prefixName($this->fieldNamesPrefix);
                $field->prefixLabel($this->fieldLabelsPrefix);
                $field->suffixLabel($this->fieldLabelsSuffix);

                $extraSettings = (isset($this->fieldsSettings[$field->getOriginalKey()])
                    ? $this->fieldsSettings[$field->getOriginalKey()] : false);

                if ($extraSettings !== false) {

                    $field->setSettings($extraSettings);

                }

            }

        }

        $this->preparedForAcfArray = true;

    }

    /**
     * Removes a field from the collection. Note that the actual removal does not take place until the collection is
     * finalized.
     *
     * @param string $fieldName The name of a field. Not the key, not the label, the name.
     *
     * @return FieldGroup
     */
    public function removeField($fieldName)
    {

        $this->fieldsToRemove[] = $fieldName;

        return $this;

    }

    /**
     * @param $key
     */
    public function removeFieldByKey($key)
    {

        $this->fieldsToRemoveByKey[] = $key;

    }

    /**
     * Remove a bunch of fields in one function call. Utilizes the function removeField. Note that the actual removal
     * of the field does not take place until the collection is finalized.
     *
     * @param array $fieldNames Array of names of fields to remove.
     *
     * @return FieldGroup
     */
    public function removeFields($fieldNames)
    {

        foreach ($fieldNames AS $fieldName) {

            $this->removeField($fieldName);

        }

        return $this;

    }

    /**
     * @param array $keys
     */
    public function removeFieldsByKey($keys)
    {

        foreach($keys AS $key) {

            $this->removeFieldByKey($key);

        }

    }

    /**
     * @param string $name
     * @param        $value
     *
     * @return $this
     */
    public function setArg($name, $value)
    {

        $this->args[$name] = $value;

        return $this;

    }

    /**
     * Set a string that will be prefixed to the labels of the fields that are added to this field group.
     *
     * @param $prefix
     *
     * @return $this
     */
    public function setFieldLabelsPrefix($prefix)
    {

        $this->fieldLabelsPrefix = $prefix;

        return $this;

    }

    /**
     * Set a string that will be prefixed to the names of the fields that are added to this field group.
     *
     * @param string $prefix
     *
     * @return $this
     */
    public function setFieldNamesPrefix($prefix)
    {

        $this->fieldNamesPrefix = $prefix;

        return $this;

    }

    /**
     * If you change your mind about removing a field, use this function to un-remove it. Since we are not actually
     * adding a field, we are un-removing it.
     *
     * @param string $fieldName
     *
     * @return FieldGroup
     */
    public function unRemoveField($fieldName)
    {

        unset($this->fieldsToRemove[$fieldName]);

        return $this;

    }

    /**
     * @param $key
     *
     * @return FieldCollection
     */
    public function unRemoveFieldByKey($key)
    {

        unset($this->fieldsToRemoveByKey[$key]);

        return $this;

    }

    /**
     * @param $fieldNames
     *
     * @return $this
     */
    public function unRemoveFields($fieldNames)
    {

        foreach ($fieldNames AS $fieldName) {

            $this->unRemoveField($fieldName);

        }

        return $this;

    }

    /**
     * @param $keys
     *
     * @return $this
     */
    public function unRemoveFieldsByKey($keys)
    {

        foreach ($keys AS $key) {

            $this->unRemoveFieldByKey($key);

        }

        return $this;

    }

}
