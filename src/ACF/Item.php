<?php

namespace Fewbricks\ACF;

/**
 * Class Item
 *
 * Generic ACF item used for anything that has a label, name, key and settings
 *
 * @package Fewbricks\ACF
 */
class Item
{

    /**
     * @var string The key required by ACF. Must be unique across the site.
     */
    protected $key;

    /**
     * @var string
     */
    protected $label;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string|boolean A place to store the original key before we merge it
     * with parent field groups, bricks etc.
     */
    protected $originalKey;

    /**
     * @var string The key of the brick, if any, that this item is part of.
     */
    protected $parentBrickKey;

    /**
     * @var string The name of the brick, if any, that this item is part of.
     */
    protected $parentBrickName;

    /**
     * The array that makes up the field.
     * https://www.advancedcustomfields.com/resources/register-fields-via-php/#field-settings
     *
     * @var array
     */
    protected $settings;

    /**
     * Field constructor.
     *
     * @param string $label    The label of the field
     * @param string $name     The name of the field
     * @param string $key      The key of the field. Must be unique across the entire app
     */
    public function __construct($label, $name, $key)
    {

        // Lets keep these crucial settings as class vars to make them easier
        // and nicer to access.
        $this->label = $label;
        $this->name  = $name;
        $this->key   = $key;

        $this->originalKey = $key;

        $this->parentBrickKey  = false;
        $this->parentBrickName = false;

    }

    /**
     * Allows you to set multiple settings at once.
     *
     * @param $settings
     */
    public function setSettings($settings)
    {

        foreach ($settings AS $name => $value) {

            $this->setSetting($name, $value);

        }

    }

    /**
     * @param $name
     * @param $value
     */
    public function setSetting($name, $value)
    {

        $classVars = ['key', 'label', 'name', 'type'];

        // Make sure to keep any crucial setting class vars up to date
        if (in_array($name, $classVars)) {
            $this->{$name} = $value;
        }

        $this->settings[$name] = $value;

    }

    /**
     * @return string
     */
    public function getLabel()
    {

        return $this->label;

    }

    /**
     * @return string
     */
    public function getName()
    {

        return $this->name;

    }

    /**
     * @return string
     */
    public function getOriginalKey()
    {

        return $this->originalKey;

    }

    /**
     * @return string|boolean
     */
    public function getParentBrickKey()
    {

        return $this->parentBrickKey;

    }

    /**
     * @param $key
     */
    public function setParentBrickKey($key)
    {

        $this->parentBrickKey = $key;

    }

    /**
     * @return string|boolean
     */
    public function getParentBrickName()
    {

        return $this->parentBrickName;

    }

    /**
     * @param $name
     */
    public function setParentBrickName($name)
    {

        $this->parentBrickName = $name;

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
     * @param $prefix
     */
    public function prefixKey($prefix)
    {

        $this->key = $prefix . $this->key;

    }

    /**
     * @param string $prefix
     */
    public function prefixLabel($prefix)
    {

        $this->label = $prefix . $this->label;

    }

    /**
     * @param string $prefix
     */
    public function prefixName($prefix)
    {

        $this->name = $prefix . $this->name;

    }

    /**
     * @param string $suffix
     */
    public function suffixLabel($suffix)
    {

        $this->label .= $suffix;

    }

    /**
     * @return array
     */
    public function toAcfArray()
    {

        $settings          = $this->settings;
        $settings['key']   = $this->getKey();
        $settings['label'] = $this->label;
        $settings['name']  = $this->name;

        return $settings;

    }

    /**
     * @return string The key of the field
     */
    public function getKey()
    {

        return $this->key;

    }

    /**
     * @param string $key
     */
    public function setKey($key)
    {

        $this->key = $key;

    }

}
