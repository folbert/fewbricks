<?php

namespace Fewbricks\ACF;

use Fewbricks\Collection;
use Fewbricks\SharedFields;

/**
 * Class FieldCollection
 *
 * @package Fewbricks\ACF
 */
class FieldCollection extends Collection
{

    /**
     * @var
     */
    protected $args;

    /**
     * @var
     */
    private $fieldLabelsPrefix;

    /**
     * @var string
     */
    private $fieldNamesPrefix;

    /**
     * @var array
     */
    private $fieldsToRemove;

    /**
     * @var array
     */
    private $fieldsToAddAfterFieldsOnBuild;

    /**
     * @var array
     */
    private $fieldsToAddBeforeFieldsOnBuild;

    /**
     * FieldCollection constructor.
     *
     * @param $args
     */
    public function __construct($args = [])
    {


        if (!is_array($args)) {
            $args = [];
        }

        $this->args = $args;

        $this->fieldNamesPrefix               = '';
        $this->fieldLabelsPrefix              = '';
        $this->fieldsToRemove                 = [];
        $this->fieldsToAddAfterFieldsOnBuild  = [];
        $this->fieldsToAddBeforeFieldsOnBuild = [];

        parent::__construct();

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

            $this->addFields($fields->getItems());

        }

    }

    /**
     * @param Field $field
     *
     * @throws \Fewbricks\KeyInUseException
     */
    public function addField($field)
    {

        $field->prefixName($this->fieldNamesPrefix);
        $field->prefixLabel($this->fieldLabelsPrefix);

        try {

            $this->addItem($field, $field->getKey());

        } catch (KeyInUseException $keyInUseException) {

            $keyInUseException->wpDie();

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
     * @param $fieldNames
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
     * @param string $fieldName The name of a field. Not the key, not the label, the name.
     *
     * @return FieldGroup
     */
    public function removeField($fieldName)
    {

        // Use the field name as index to allow us to use isset() later on which is faster than in_array
        // https://stackoverflow.com/questions/13483219/what-is-faster-in-array-or-isset
        $this->fieldsToRemove[$fieldName] = $fieldName;

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
     *
     */
    protected function doRemoveFields()
    {

        foreach ($this->fieldsToRemove AS $fieldToRemove) {

            $this->removeItemByName($fieldToRemove);

        }

    }

    /**
     * @param $name
     */
    public function removeItemByName($name)
    {

        /** @var Field $field */
        foreach ($this->items AS $item_key => $field) {

            if ($field->getName() === $name) {

                parent::removeItem($item_key);

            }

        }

    }

    /**
     *
     */
    protected function doAddFieldsAfter()
    {

        foreach ($this->fieldsToAddAfterFieldsOnBuild AS $data) {

            $this->addItemAfterByName($data[0], $data[1]);

        }

    }

    /**
     *
     */
    protected function doAddFieldsBefore()
    {

        foreach ($this->fieldsToAddBeforeFieldsOnBuild AS $data) {

            $this->addItemBeforeByName($data[0], $data[1]);

        }

    }

    /**
     * @param $item
     * @param $nameToAddAfter
     */
    public function addItemAfterByName($item, $nameToAddAfter)
    {

        /** @var Field $itemToAddAfter */
        $itemToAddAfter = $this->getItemByName($nameToAddAfter);

        if ($itemToAddAfter !== false) {

            $this->addItemAfter($item, $itemToAddAfter->getKey());

        }

    }

    /**
     * @param $item
     * @param $nameToAddBefore
     */
    public function addItemBeforeByName($item, $nameToAddBefore)
    {

        /** @var Field $itemToAddAfter */
        $itemToAddBefore = $this->getItemByName($nameToAddBefore);

        if ($itemToAddBefore !== false) {

            $this->addItemBefore($item, $itemToAddBefore->getKey());

        }

    }

    /**
     * @param $name
     *
     * @return bool|mixed
     */
    public function getItemByName($name)
    {

        $item = false;

        /**
         * @var string $item_key
         * @var Field  $field
         */
        foreach ($this->items AS $item_key => $field) {

            if ($field->getName() === $name) {

                $item = parent::getItem($item_key);

            }

        }

        return $item;

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
     * @param string $baseKey
     *
     * @return array An array that ACF can work with.
     */
    public function getAcfArray($baseKey)
    {

        $this->doRemoveFields();
        $this->doAddFieldsAfter();
        $this->doAddFieldsBefore();

        // Lets make sure that the key is ok for ACF
        // https://www.advancedcustomfields.com/resources/register-fields-via-php/#field-settings
        if (substr($baseKey, 0, 6) !== 'field_') {
            $baseKey = 'field_' . $baseKey;
        }

        return $this->finalizeSettings($this->items, $baseKey);

    }

    /**
     * @param Field[] $fieldObjects
     * @param string  $base_key
     *
     * @return array Associative array with field settings ready to be used for
     * "fields" in an array to be sent to ACFs functions for
     * registering fields using code.
     * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/#example
     */
    private function finalizeSettings($fieldObjects, $base_key)
    {

        $settings = [];

        foreach ($fieldObjects AS $fieldObject) {

            $keyPrepend = $base_key;

            // If the field belongs to a brick
            if (false !== ($brickKey = $fieldObject->getBrickKey())) {
                $keyPrepend .= '_' . $brickKey;
            }

            $keyPrepend .= '_';

            $fieldObject->prependKey($keyPrepend);

            $settings[] = $fieldObject->getAcfArray();

        }

        $settings = $this->prepareFieldsConditionalLogic($settings);

        return $settings;

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
                foreach ($conditionalLogic AS $lvl1Key => $lvl1Value) {

                    foreach ($conditionalLogic[$lvl1Key] AS $lvl2Key => $lvl2Value) {

                        $targetFieldKey = $conditionalLogic[$lvl1Key][$lvl2Key]['field'];

                        foreach ($this->items AS $otherFieldObject) {

                            if ($otherFieldObject->getOriginalKey() === $targetFieldKey) {

                                $conditionalLogic[$lvl1Key][$lvl2Key]['field'] = $otherFieldObject->getKey();

                            }

                        }

                    }

                }

                $fieldsSettings[$fieldSettingsKey]['conditional_logic'] = $conditionalLogic;

            }

        }

        return $fieldsSettings;

    }

}
