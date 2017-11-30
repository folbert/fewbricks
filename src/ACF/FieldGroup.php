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
     * @var RuleGroupCollection
     */
    private $ruleGroups;

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
        $this->ruleGroups = new RuleGroupCollection();

    }

    /**
     * @param $ruleGroup
     */
    public function addRuleGroup($ruleGroup)
    {

        $this->ruleGroups->addItem($ruleGroup);

    }

    /**
     * ACF setting. If the ficle group should be registered or not.
     *
     * @param $active
     *
     * @return $this
     */
    public function setActive($active)
    {

        $this->setSetting('active', $active);

        return $this;

    }

    /**
     * ACF setting. Shown in field group list. Since this is a setting
     * that only affects the ACF GUI, it will probably never be used by Fewbricks
     * users. But lets add this function anyways just to be nice :)
     *
     * @param string $description The description
     *
     * @return $this
     */
    public function setDescription($description)
    {

        $this->setSetting('decsription', $description);

        return $this;

    }

    /**
     * ACF setting. An array of elements to hide on the screen.
     * Important: If multiple field groups appear on an edit screen, the first
     * field group's options will be used (the one with the lowest
     * order number).
     *
     * Possible values in the array: 'permalink', 'the_content', 'excerpt',
     * 'custom_fields', 'discussion', 'comments', 'revisions', 'slug',
     * 'author', 'format', 'page_attributes', 'featured_image', 'categories',
     * 'tags', 'send-trackbacks'
     *
     * @param array $hideOnScreen Array with items to hide on the screen.
     * @param array $showOnScreen Fewbricks addition. Enables you to define
     *                            which fields should be visible on screen. This
     *                            will create an array with all the items that
     *                            ACF supports hiding of and then remove the
     *                            items in $showOnScreen. Passing a non-empty
     *                            value here will make the function ignore the
     *                            $hideOnScreen variable completely
     *
     * @return $this
     */
    public function setHideOnScreen($hideOnScreen, $showOnScreen = [])
    {

        if (!empty($showOnScreen)) {

            // These are the items that ACF supports hiding as of v5.6.5
            $hideOnScreen = array_diff([
                'permalink',
                'the_content',
                'excerpt',
                'custom_fields',
                'discussion',
                'comments',
                'revisions',
                'slug',
                'author',
                'format',
                'page_attributes',
                'featured_image',
                'categories',
                'tags',
                'send-trackbacks',
            ], $showOnScreen);

        }

        $this->setSetting('hide_on_screen', $hideOnScreen);

        return $this;

    }

    /**
     * ACF Setting. Determines where field instructions are placed in relation
     * to fields.
     *
     * @param string $instruction_placement 'label' (Below labels) or 'field'
     *                                      (Below fields)
     *
     * @return $this
     */
    public function setInstructionPlacement($instruction_placement)
    {

        $this->setSetting('instruction_placement', $instruction_placement);

        return $this;

    }

    /**
     * ACF Setting. Determines where field labels
     *                               are placed in relation to fields.
     *                               Defaults to 'top'.
     *
     * @param string $labelPlacement 'top' (Above fields) or 'left'
     *                               (Beside fields)
     *
     * @return $this
     */
    public function setLabelPlacement($labelPlacement)
    {

        $this->setSetting('label_placement', $labelPlacement);

        return $this;


    }

    /**
     * @param $location
     *
     * @return $this
     */
    public function setLocation($location)
    {

        $this->setSetting('location', $location);

        return $this;

    }

    /**
     * ACF setting. Field groups are shown in order from lowest to highest.
     *
     * @param int $menuOrder
     *
     * @return $this
     */
    public function setMenuOrder($menuOrder)
    {

        $this->setSetting('menu_order', $menuOrder);

        return $this;

    }

    /**
     * ACF setting. Determines the position on the edit screen. Defaults to
     * normal.
     *
     * @param string $position 'acf_after_title', 'normal' or 'side'
     *
     * @return $this
     */
    public function setPosition($position)
    {

        $this->setSetting('position', $position);

        return $this;

    }

    /**
     * Enables you to add values to the settings directly. So if ACF adds new
     * settings, you don't have to wait for Fewbricks to add functions for you
     * to be able to set them.
     *
     * @param $name
     * @param $value
     *
     * @return $this
     */
    public function setSetting($name, $value)
    {

        $crucialSettings = ['location', 'key', 'title'];

        // Make sure to keep any crucial setting class vars up to date
        if (in_array($name, $crucialSettings)) {
            $this->{$name} = $value;
        }

        $this->settings[$name] = $value;

        return $this;

    }

    /**
     * Determines the metabox style. Choices of 'default' or 'seamless'
     *
     * @param string $style 'default' or 'seamless'
     *
     * @return $this
     */
    public function setStyle($style)
    {

        $this->setSetting('style', $style);

        return $this;

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

        // Cal the build function
        $this->build();

        $acfSettingsArray = $this->getAcfSettingsArray();

        //dump($acfSettingsArray);

        acf_add_local_field_group($acfSettingsArray);

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
