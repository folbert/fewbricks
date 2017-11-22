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
     * @var FieldCollection
     */
    private $fieldObjects;

    /**
     * @var
     */
    private $key;

    /**
     * @var array
     */
    private $location;

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
        $location,
        $settings = [],
        $args = []
    ) {

        if (!is_array($settings)) {
            $settings = [];
        }

        // Let's keep these crucial settings as class vars to enable nicer
        // and more OOP-oriented access
        $this->title    = $title;
        $this->key      = $key;
        $this->location = $location;

        $this->settings = $settings;

        if (!is_array($args)) {
            $args = [];
        }

        // @todo Are these ever used?
        $this->args = $args;

        $this->fieldObjects = new FieldCollection();

    }

    /**
     * ACF setting. An array of elements to hide on the screen
     *
     * @param array $hideOnScreen
     */
    public function setHideOnScreen($hideOnScreen)
    {

        //@todo Use this value for something
        $this->setSetting('hide_on_screen', $hideOnScreen);

    }

    /**
     * ACF Setting. Determines where field instructions are places in relation
     * to fields.
     *
     * @param string $instruction_placement 'label' (Below labels) or 'field'
     *                                      (Below fields)
     */
    public function setInstructionPlacement($instruction_placement)
    {

        $this->setSetting('instruction_placement', $instruction_placement);

    }

    /**
     * ACF Setting. Determines where field labels
     *                               are placed in relation to fields.
     *                               Defaults to 'top'.
     *
     * @param string $labelPlacement 'top' (Above fields) or 'left'
     *                               (Beside fields)
     */
    public function setLabelPlacement($labelPlacement)
    {

        $this->setSetting('label_placement', $labelPlacement);


    }

    /**
     * @param $location
     */
    public function setLocation($location)
    {

        $this->setSetting('location', $location);

    }

    /**
     * ACF setting. Field groups are shown in order from lowest to highest.
     *
     * @param int $menuOrder
     */
    public function setMenuOrder($menuOrder)
    {

        $this->setSetting('menu_order', $menuOrder);

    }

    /**
     * ACF setting. Determines the position on the edit screen. Defaults to
     * normal.
     *
     * @param string $position 'acf_after_title', 'normal' or 'side'
     */
    public function setPosition($position)
    {

        $this->setSetting('position', $position);

    }

    /**
     * Enables you to add values to the settings directly. So if ACF adds new
     * settings, you don't have to wait for Fewbricks to add functions for you
     * to be able to set them.
     *
     * @param $name
     * @param $value
     */
    public function setSetting($name, $value)
    {

        $crucialSettings = ['location', 'key', 'title'];

        // Make sure to keep any crucial setting class vars up to date
        if(in_array($name, $crucialSettings)) {
            $this->{$name} = $value;
        }

        $this->settings[$name] = $value;

    }

    /**
     * Determines the metabox style. Choices of 'default' or 'seamless'
     *
     * @param string $style 'default' or 'seamless'
     */
    public function setStyle($style)
    {

        $this->setSetting('style', $style);

    }

    /**
     * @return FieldCollection
     */
    public function getFieldObjects()
    {

        return $this->fieldObjects;

    }

    /**
     * @return string
     */
    public function getKey()
    {

        return $this->key;

    }

    /**
     * Get the value of a specific setting.
     *
     * @param      $name         The name of the setting
     * @param bool $defaultValue The value to return if the setting does not
     *                           exist
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

        // Cal teh build function
        $this->build();

        // Add the crucial settings to the field group
        $this->settings['key']   = $this->key;
        $this->settings['title'] = $this->title;

        acf_add_local_field_group($this->getAcfSettingsArray());

        // No use in having a potentially large collection of objects anymore
        unset($this->fieldObjects);

    }

    /**
     * @param Field $field
     */
    public function addField($field)
    {

        $this->fieldObjects->addItem($field);

    }

    /**
     * @return array
     */
    public function getAcfSettingsArray()
    {

        return array_merge($this->settings, [
            'key'      => $this->key,
            'title'    => $this->title,
            'fields'   => $this->fieldObjects->getFinalizedSettings($this->key),
            'location' => $this->location,
        ]);

    }

    /**
     * Empty function to be called when field groups are created on the fly.
     * Any class extending this class should always have a build function.
     */
    public function build()
    {

    }

}
