<?php

namespace Fewbricks\ACF;

class FieldGroup
{

    /**
     * The array that actually makes up the field group since it holds all the settings for the group
     *
     * @var array
     */
    private $settings;

    /**
     * FieldGroup constructor.
     *
     * @param string $title
     * @param string $key
     * @param array  $location
     * @param array  $settings Any other settings that will affect ACF.
     *                         https://www.advancedcustomfields.com/resources/register-fields-via-php/#group-settings
     */
    public function __construct($title, $key, $location = [], $settings = [])
    {

        // These are the minimum set of settings that ACF requires.
        $settings['title']    = $title;
        $settings['key']      = $key;
        $settings['location'] = $location;
        $settings['fields']   = [];

        $this->settings = $settings;

        //@todo Deal with hide_on_screen

    }

    /**
     * @param Field $field
     */
    public function addField($field)
    {

        $this->settings['fields'][] = $field->getSettings();

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

        acf_add_local_field_group($this->settings);

    }

}
