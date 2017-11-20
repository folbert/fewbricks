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
     * @var array
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

        $this->prepareKeys();
        $this->createAcfFieldArrays();

        // Add the crucial values
        $this->settings['key']   = $this->key;
        $this->settings['title'] = $this->title;

        // No use in having a potentially large collection of objects anymore
        unset($this->fieldObjects);

        acf_add_local_field_group($this->settings);

    }

    /**
     * We must modify the field keys to make sure that they are unique across
     * the site. We do this at this level by pre-pending the field groups key.
     */
    private function prepareKeys()
    {

        /** @var Field $fieldObject */
        foreach ($this->fieldObjects AS &$fieldObject) {

            if ($fieldObject->getKeyPrepared() === false) {

                $fieldObject->prepareKey($this->getKey());

            }

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
