<?php

namespace Fewbricks\ACF;

class Field
{

    /**
     * The array that makes up the field.
     * https://www.advancedcustomfields.com/resources/register-fields-via-php/#field-settings
     *
     * @var array
     */
    private $settings;

    /**
     * Field constructor.
     *
     * @param       $type
     * @param       $label
     * @param       $name
     * @param       $key
     * @param array $settings
     */
    public function __construct($type, $label, $name, $key, $settings = [])
    {

        $settings['type']  = $type;
        $settings['label'] = $label;
        $settings['name']  = $name;
        // Make sure that key starts with "field_" as required by ACF.
        $settings['key'] = (substr(0, 6) !== 'field_' ? 'field_' . $key : $key);

        $this->settings = $settings;

    }

    /**
     * @return array
     */
    public function getSettings()
    {

        return $this->settings;

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
     * @param $name
     * @param $value
     */
    public function setSetting($name, $value)
    {

        $this->settings[$name] = $value;

    }

}
