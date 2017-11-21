<?php

namespace Fewbricks\ACF;

class Field
{

    /**
     * @var The key of the brick, if any, that this field is part of.
     */
    private $brickKey;

    /**
     * @var The key required by ACF. Must be unique across the site.
     */
    private $key;

    /**
     * @var If the key has been prepared for a field group or not.
     *         Once it has been, it should not be changed.
     */
    private $keyPreparedForFieldGroup;

    /**
     * @var string
     */
    private $label;

    /**
     * @var string
     */
    private $name;

    /**
     * @var A place to store the original key before we merge it with parent
     *        field groups, bricks etc.
     */
    private $originalKey;

    /**
     * The array that makes up the field.
     * https://www.advancedcustomfields.com/resources/register-fields-via-php/#field-settings
     *
     * @var array
     */
    private $settings;

    /**
     * @var string
     */
    private $type;

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
        $this->type  = $type;
        $this->label = $label;
        $this->name  = $name;
        $this->key   = $key;

        // ACF states that keys must start with field_ but let's wait with
        // ensuring that until the key has been prepended with keys of
        // field groups, bricks etc.

        $this->settings = $settings;

        $this->originalKey              = $key;
        $this->keyPreparedForFieldGroup = false;

        $this->brickKey = false;

    }

    /**
     * @return string|boolean
     */
    public function getBrickKey()
    {

        return $this->brickKey;

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
    /*public function getKeyPreparedForFieldGroup()
    {

        return $this->keyPreparedForFieldGroup;

    }*/

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
        $tmp_settings          = $this->settings;
        $tmp_settings['key']   = $this->key;
        $tmp_settings['label'] = $this->label;
        $tmp_settings['name']  = $this->name;
        $tmp_settings['type']  = $this->type;

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
     * @param mixed $defaultValue ACF setting. A default value used by ACF if no
     *                            value has yet been saved.
     */
    public function setDefaultValue($defaultValue)
    {

        $this->setSetting('default_value', $defaultValue);

    }

    /**
     * @param array $conditionalLogic ACF setting. Conditionally hide or show
     *                                this field based on other field's values.
     *                                Best to use the ACF UI and export to
     *                                understand the array structure.
     */
    public function setConditionalLogic($conditionalLogic)
    {

        $this->setSetting('conditional_logic', $conditionalLogic);

    }

    /**
     * @param string $instructions ACF setting. Instructions for authors.
     *                             Shown when submitting data
     */
    public function setInstructions($instructions)
    {

        $this->setSetting('instructions', $instructions);

    }

    /**
     * @param boolean $required     ACF setting. Whether or not the field value
     *                              is required. If not set, false is used.
     */
    public function setRequired($required)
    {

        $this->setSetting('required', $required);

    }

    /**
     * @param boolean $wrapper ACF setting. An array of attributes given to the
     *                         field element in the backend.
     */
    public function setWrapper($wrapper)
    {

        // Make sure all indexes are set.
        $wrapper = array_merge([
            'width' => '',
            'class' => '',
            'id'    => '',
        ], $wrapper);

        $this->setSetting('wrapper', $wrapper);

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
    public function setKeyPreparedForFieldGroup($value)
    {

        $this->keyPreparedForFieldGroup = $value;

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
     * @param $prepend
     */
    public function prependKey($prepend)
    {

        $this->key = $prepend . $this->key;

    }

    /**
     * @param string $prepend    Value to prepend
     * @param object $prepareFor The object that the key should be prepared for.
     *
     */
    /*public function prepareKey($prepend, $prepareFor)
    {

        // When a key has been prepared for a field group,
        // we can consider it finalized
        if (!$this->keyPreparedForFieldGroup) {

            // If we are preparing for a field group which is at the top
            // of the hierarchy and the last type to call prepare keys,
            // we need to make sure that we start with "_field" as defined
            // by ACF.
            // https://www.advancedcustomfields.com/resources/register-fields-via-php/#field-settings
            if ($prepareFor instanceof FieldGroup) {

                if (substr($prepend, 0, 6) !== 'field_') {
                    $prepend = 'field_' . $prepend;
                }

                $this->keyPreparedForFieldGroup = true;

            }

            $this->key = $prepend . '_' . $this->key;

        }

    }*/

}
