<?php

namespace Fewbricks\ACF;

class Field
{

    /**
     * @var
     */
    private $key;

    /**
     * The array that makes up the field.
     * https://www.advancedcustomfields.com/resources/register-fields-via-php/#field-settings
     *
     * @var array
     */
    private $settings;

    /**
     * @var A place to store the original key before we merge it with parent
     *        field groups, bricks etc.
     */
    private $originalKey;

    /**
     * @var If the key has been prepared by Fewbricks or not
     */
    private $keyPrepared;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $label;

    /**
     * @var string
     */
    private $name;

    /**
     * Field constructor.
     *
     * @param string $type     A name corresponding to the name of an ACF field
     *                         or a public add-on.
     * @param string $label    The label of the field
     * @param string $name     The name of the field
     * @param string $key      The key of the field. Must be unique across the
     *                         entire app
     * @param array  $settings Array where you can pass all the possible
     *                         settings for the field.
     *                         https://www.advancedcustomfields.com/resources/register-fields-via-php/#field-type%20settings
     */
    public function __construct($type, $label, $name, $key, $settings = [])
    {

        // Lets keep these crucial settings as class vars to make them easier
        // and nicer to access.
        $this->type = $type;
        $this->label = $label;
        $this->name = $name;
        $this->key = $key;

        // ACF states that keys must start with field_ but let's wait with
        // ensuring that until the key has been prepended with keys of
        // field groups, bricks etc.

        $this->settings = $settings;

        $this->originalKey = $key;
        $this->keyPrepared = false;

    }

    /**
     * @return string The key of the field
     */
    public function getKey()
    {

        return $this->key;

    }

    /**
     * @return bool|If
     */
    public function getKeyPrepared()
    {

        return $this->keyPrepared;

    }

    public function getOriginalKey()
    {

        return $this->originalKey;

    }

    /**
     * @return array
     */
    public function getSettings()
    {

        // Put the crucial settings into the settings array
        $tmp_settings = $this->settings;
        $tmp_settings['key'] = $this->key;
        $tmp_settings['label'] = $this->label;
        $tmp_settings['name'] = $this->name;
        $tmp_settings['type'] = $this->type;

        return $tmp_settings;

    }

    /**
     * Get the value of a specific setting. Please note that you can only
     * get the settings that you have set when creating the instance.
     * Any default values that are set by ACF and that has not been overridden
     * in this instance will return the $defaultValue
     *
     * @param string $name         The name of the setting to get
     * @param bool   $defaultValue Value to return if setting is not set
     *
     * @return mixed $defaultValue if value was not found, otherwise the value
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
     * @param string $key
     */
    public function setKey($key)
    {

        $this->key = $key;

    }

    /**
     * @param bool $value
     */
    public function setKeyPrepared($value)
    {

        $this->keyPrepared = $value;

    }

    /**
     * @param $name
     * @param $value
     */
    public function setSetting($name, $value)
    {

        $this->settings[$name] = $value;

    }

    public function prepareKey($append)
    {

        /**
         *
         */
        if(!$this->keyPrepared) {

            // @todo Below should only be done when registering to field group
            // Make sure that key starts with field_
            if(substr($append, 0,6) !== 'field_') {
                $append = 'field_' . $append;
            }

            $this->key = $append . '_' . $this->key;

        }

    }

}
