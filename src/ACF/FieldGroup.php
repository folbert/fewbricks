<?php

namespace Fewbricks\ACF;

/**
 * Class FieldGroup
 *
 * @package Fewbricks\ACF
 */
class FieldGroup
{

    /**
     * @var array An array enabling you to pass any argument that you need.
     */
    private $args;

    /**
     * @var Field[]
     */
    private $fieldObjects;

    /**
     * @var
     */
    private $key;

    /**
     * The array that actually makes up the field group since it holds all the
     * settings for the group
     *
     * @var array
     */
    private $settings;

    /**
     * @var
     */
    private $title;

    /**
     * FieldGroup constructor.
     *
     * @param string $title
     * @param string $key
     * @param array  $location
     * @param array  $settings Any other settings that will affect ACF.
     *                         https://www.advancedcustomfields.com/resources/register-fields-via-php/#group-settings
     * @param array  $args     An array enabling you to pass any argument that
     *                         you need.
     */
    public function __construct(
        $title,
        $key,
        $location = [],
        $settings = [],
        $args = []
    ) {

        if (!is_array($settings)) {
            $settings = [];
        }

        // Let's keep these crucial settings as class vars to enable nicer
        // and more OOP-oriented access
        $this->title = $title;
        $this->key   = $key;

        // Except key and title,
        // these are the minimum set of settings that ACF requires.
        $settings['location'] = $location;

        $this->settings = $settings;

        if (!is_array($args)) {
            $args = [];
        }

        $this->args = $args;

        $this->fieldObjects = [];

        //@todo Deal with hide_on_screen

    }

    /**
     * @param Field $field
     */
    public function addField($field)
    {

        $this->fieldObjects[] = $field;

    }

    /**
     * @param $name
     * @param $value
     */
    public function setSetting($name, $value)
    {

        $this->settings[$name] = $value;

    }

    /**
     * @return string
     */
    public function getFields()
    {

        return $this->getSetting('fields');

    }

    public function getKey()
    {

        return $this->key;

    }

    /**
     * Get the value of a specific setting.
     *
     * @param      $name         The name of the setting
     * @param bool $defaultValue The value to return if the setting does not exist
     *
     * @return bool|mixed
     */
    public function getSetting($name, $defaultValue = false)
    {

        $value = $defaultValue;

        if (isset($this->settings[$name])) {
            $value = $this->settings[$name];
        }

        return $value;

    }

    /**
     * @return array
     */
    public function getSettings()
    {

        return $this->settings;

    }

    /**
     * Tell ACF that this field group exists
     */
    public function register()
    {

        $this->build();

        $this->prepareFields();
        $this->createAcfFieldArrays();

        // Add the crucial settings
        $this->settings['key'] = $this->key;
        $this->settings['title'] = $this->title;

        // No use in having a potentially large collection of objects anymore
        unset($this->fieldObjects);

        acf_add_local_field_group($this->settings);

    }

    /**
     *
     */
    private function prepareFields()
    {

        // @todo Create a dedicated class, FieldSettingFinalizer, to handle this on an array of field objects

        $this->prepareFieldKeys();
        $this->prepareFieldsConditionalLogic();

    }

    /**
     *
     */
    private function prepareFieldKeys()
    {

        /** @var Field $fieldObject */
        foreach ($this->fieldObjects AS &$fieldObject) {
            $this->prepareFieldKey($fieldObject);
        }
        unset($fieldObject);

    }

    /**
     * We must modify the field keys to make sure that they are unique across
     * the site. We do this at this level by pre-pending the field groups key.
     *
     * @param Field $fieldObject
     */
    private function prepareFieldKey(&$fieldObject)
    {

        $prepend = 'field_' . $this->key;

        if (false !== ($brickKey = $fieldObject->getBrickKey())) {
            $prepend .= '_' . $brickKey;
        }

        $prepend .= '_';

        $fieldObject->prependKey($prepend);

    }

    /**
     *
     */
    private function prepareFieldsConditionalLogic()
    {

        /** @var Field $fieldObject */
        foreach ($this->fieldObjects AS &$fieldObject) {
            $this->prepareFieldConditionalLogic($fieldObject);
        }
        unset($fieldObject);

    }

    /**
     * @param Field $fieldObject
     */
    private function prepareFieldConditionalLogic(&$fieldObject)
    {

        $fieldObjectSettings = $fieldObject->getSettings();

        // Do the field have conditional logic
        if (isset($fieldObjectSettings['conditional_logic'])
            && is_array($fieldObjectSettings['conditional_logic'])
        ) {

            $conditionalLogic = $fieldObjectSettings['conditional_logic'];

            // Traverse down the conditional logic array
            foreach ($conditionalLogic AS $lvl1Key => $lvl1Value) {

                foreach ($conditionalLogic[$lvl1Key] AS $lvl2Key => $lvl2Value)
                {

                    $targetFieldKey
                        = $conditionalLogic[$lvl1Key][$lvl2Key]['field'];

                    foreach ($this->fieldObjects AS $otherFieldObject) {

                        if ($otherFieldObject->getOriginalKey()
                            === $targetFieldKey
                        ) {

                            $conditionalLogic[$lvl1Key][$lvl2Key]['field']
                                = $otherFieldObject->getKey();

                        }

                    }


                }

            }

            $fieldObject->setSetting('conditional_logic', $conditionalLogic);

        }

    }

    /**
     *
     */
    private function createAcfFieldArrays()
    {

        $fieldsArray = [];

        /** @var Field $fieldObject */
        foreach ($this->fieldObjects AS $fieldObject) {

            $fieldsArray[] = $fieldObject->getSettings();

        }

        $this->settings['fields'] = $fieldsArray;

    }

    /**
     * @return array
     */
    private function getFieldObjects()
    {

        return $this->fieldObjects;

    }

    /**
     * Empty function to be called when field groups are created on the fly.
     * Any class extending this class should always have a build function.
     */
    public function build()
    {

    }

}
