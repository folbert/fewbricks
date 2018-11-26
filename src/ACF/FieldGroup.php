<?php

namespace Fewbricks\ACF;

use Fewbricks\DevTools;
use Fewbricks\Exporter;
use Fewbricks\Helper;

/**
 * Class FieldGroup
 * This is a glorified FieldCollection
 *
 * @package Fewbricks\ACF
 */
class FieldGroup extends FieldCollection implements FieldGroupInterface
{

    /**
     * The items that ACF supports hiding as of v5.6.5
     */
    private const HIDE_ON_SCREEN_ITEMS
        = [
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
        ];

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $key;

    /**
     * @var RuleGroupCollection
     */
    private $location_rule_groups;

    /**
     * The array that actually makes up the field group since it holds all the
     * settings for the group
     *
     * @var array
     */
    private $settings;

    /**
     * FieldGroup constructor.
     *
     * @param string $title
     * @param string $key
     */
    public function __construct(string $title, string $key)
    {

        // Let's keep these crucial settings as class vars to enable nicer
        // and more OOP-oriented access
        $this->title = $title;
        $this->key = $key;
        $this->settings = [];
        $this->clearLocationRuleGroups();

        parent::__construct();

    }

    /**
     * @param FieldGroupLocationRuleGroup $rule_group
     */
    public function addLocationRuleGroup(FieldGroupLocationRuleGroup $rule_group)
    {

        $this->location_rule_groups->addItem($rule_group);

    }

    /**
     * @param FieldGroupLocationRuleGroup[] $rule_groups
     */
    public function addLocationRuleGroups(array $rule_groups)
    {

        foreach ($rule_groups AS $rule_group) {

            $this->addLocationRuleGroup($rule_group);

        }

    }

    /**
     */
    public function clearLocationRuleGroups()
    {

        $this->location_rule_groups = new RuleGroupCollection();

    }

    /**
     * ACF setting. An array of elements to hide on the screen.
     * Important: If multiple field groups appear on an edit screen, the first field group's options will be used
     * (the one with the lowest order number).
     *
     * Possible values in the array: see FieldGroup::HIDE_ON_SCREEN_ITEMS
     *
     * @param array $hide_on_screen Array with items from FieldGroup::HIDE_ON_SCREEN_ITEMS to hide on the screen or
     *                              "all" to hide all.
     *
     * @param array $show_on_screen Fewbricks addition. Enables you to define which fields should be visible on screen.
     *                              This will create an array with all the items that ACF supports hiding and then
     *                              remove the items that you have set in $showOnScreen. Passing a non-empty value here
     *                              will make the function ignore the $hideOnScreen variable completely. Possible
     *                              values: items from FieldGroup::HIDE_ON_SCREEN_ITEMS or "all" to show all.
     */
    private function doSetHideOnScreen($hide_on_screen, $show_on_screen = [])
    {

        $current_values = $this->getHideOnScreenSetting();

        if (!empty($show_on_screen)) {

            // If the user want to show all...
            if ($show_on_screen === 'all') {

                // ...we should hide nothing
                $hide_on_screen = [];

            } else {

                // Make sure we have an array
                if (!is_array($show_on_screen)) {
                    $show_on_screen = [$show_on_screen];
                }

                $hide_on_screen = array_diff($current_values, $show_on_screen);

            }

        } else {

            // If the user want to hide all
            if ($hide_on_screen === 'all') {

                $hide_on_screen = self::HIDE_ON_SCREEN_ITEMS;

            } else {

                if (!is_array($hide_on_screen)) {
                    $hide_on_screen = [$hide_on_screen];
                }

                $hide_on_screen = array_merge($current_values, $hide_on_screen);

            }

        }

        $this->setSetting('hide_on_screen', $hide_on_screen);

    }

    /**
     * @return bool|mixed
     */
    public function getActive()
    {

        return $this->getSetting('active', true);

    }

    /**
     * @return string
     */
    public function getBaseKey()
    {

        return $this->getKey();

    }

    /**
     * @return bool|mixed
     */
    public function getDescription()
    {

        return $this->getSetting('description', '');

    }

    /**
     * @return array|bool|mixed
     */
    public function getHideOnScreenSetting()
    {

        return $this->getSetting('hide_on_screen', []);

    }

    /**
     * @return bool|mixed
     */
    public function getInstructionPlacement()
    {

        return $this->getSetting('instruction_placement', 'label');

    }

    /**
     * @return string
     */
    public function getKey()
    {

        $key = $this->key;

        // Lets keep in order with how ACF gives keys to field groups and prepend with "group_"
        if (substr($key, 0, 6) !== 'group_') {
            $key = 'group_' . $key;
        }

        return $key;

    }

    /**
     * @return bool|mixed
     */
    public function getLabelPlacement()
    {

        return $this->getSetting('label_placement', 'top');

    }

    /**
     * @return RuleGroupCollection
     */
    public function getLocationRuleGroups()
    {

        return $this->location_rule_groups;

    }

    /**
     * @return bool|mixed
     */
    public function getMenuOrder()
    {

        return $this->getSetting('menu_order', 0);

    }

    /**
     * @return bool|mixed
     */
    public function getPosition()
    {

        return $this->getSetting('position', 'normal');

    }

    /**
     * Get the value of a specific setting.
     *
     * @param string $name The name of the setting
     * @param bool $default_value The value to return if the setting does not exist
     *
     * @return bool|mixed
     */
    public function getSetting($name, $default_value = false)
    {

        $value = $default_value;

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
     * @return bool|mixed
     */
    public function getStyle()
    {

        return $this->getSetting('style', 'default');

    }

    /**
     * @return string
     */
    public function getTitle()
    {

        return $this->title;

    }

    /**
     * @param $title
     */
    public function setTitle($title)
    {

        $this->title = $title;

    }

    /**
     * Called just before sending field to ACF. This way you can add this function to your own classes extending
     * this class and write any last-minute custom logic to execute right before senfing the field group to ACF.
     */
    private function prepareForRegistration()
    {

    }

    /**
     * In order to keep in sync with ACFs namings, we have this function to call publicly. And then use doRegister()
     * to actually register.
     * @param bool $unset_after_added_to_acf
     */
    public function register($unset_after_added_to_acf = true)
    {

        $this->prepareForRegistration();

        $acf_settings_array = $this->toAcfArray();

        Exporter::maybeStoreSimpleFieldGroupData($acf_settings_array['title'], $acf_settings_array['key']);
        Exporter::maybeStoreFieldGroupAcfSettings($acf_settings_array);
        DevTools::maybeStoreAcfSettingsArrayForDevDisplay($acf_settings_array);

        acf_add_local_field_group($acf_settings_array);

        if($unset_after_added_to_acf) {

            // Lets clear up some space
            unset($this->settings);
            unset($this->items);

        }

    }

    /**
     * ACF setting. If the field group should be registered or not.
     *
     * @param $active
     */
    public function setActive($active)
    {

        $this->setSetting('active', $active);

    }

    /**
     * ACF setting. Shown in field group list. Since this is a setting that only affects the ACF GUI, it will probably
     * never be used by Fewbricks users. But lets add this function anyways just to be nice :)
     *
     * @param string $description The description
     */
    public function setDescription($description)
    {

        $this->setSetting('description', $description);

    }

    /**
     * @param bool $display
     */

    public function setDisplayInFewbricksDevTools(bool $display)
    {

        $this->setSetting(DevTools::getSettingsNameForDisplayingAcfArray(), $display);

    }

    /**
     * Allow you to set which elements that should be hidden on screen.
     *
     * @see FieldGroup::doSetHideOnScreen()
     *
     * @param string|array $element_names One or many of the values of the following: 'permalink', 'the_content',
     *                                   'excerpt', 'custom_fields', 'discussion', 'comments', 'revisions', 'slug',
     *                                   'author', 'format', 'page_attributes', 'featured_image', 'categories', 'tags',
     *                                   'send-trackbacks', 'all'. Note 'all' which will show all elements that
     *                                   are possible to hide.
     */
    public function setHideOnScreen($element_names)
    {

        $this->doSetHideOnScreen($element_names);

    }

    /**
     * ACF Setting. Determines where field instructions are placed in relation to fields.
     *
     * @param string $instruction_placement 'label' (Below labels) or 'field' (Below fields)
     */
    public function setInstructionPlacement($instruction_placement)
    {

        $this->setSetting('instruction_placement', $instruction_placement);

    }

    /**
     * ACF Setting. Determines where field labels are placed in relation to fields. Defaults to 'top'.
     *
     * @param string $label_placement 'top' (Above fields) or 'left' (Beside fields)
     */
    public function setLabelPlacement($label_placement)
    {

        $this->setSetting('label_placement', $label_placement);

    }

    /**
     * ACF setting. Field groups are shown in order from lowest to highest.
     *
     * @param int $menu_order
     */
    public function setMenuOrder($menu_order)
    {

        $this->setSetting('menu_order', $menu_order);

    }

    /**
     * ACF setting. Determines the position on the edit screen. Defaults to 'normal'.
     *
     * @param string $position 'acf_after_title', 'normal' or 'side'
     */
    public function setPosition($position)
    {

        $this->setSetting('position', $position);

    }

    /**
     * Enables you to add values to the settings directly. So if ACF adds new settings, you don't have to wait for
     * Fewbricks to add functions for you to be able to set them.
     *
     * @param $name
     * @param $value
     */
    public function setSetting($name, $value)
    {

        $crucialSettings = ['key', 'title'];

        // Make sure to keep any crucial setting class vars up to date
        if (in_array($name, $crucialSettings)) {
            $this->{$name} = $value;
        }

        $this->settings[$name] = $value;

    }

    /**
     * If the element has been previously set to be hidden, this will set it to be shown instead.
     *
     * @see FieldGroup::setHideOnScreen()
     *
     * @param string|array $element_names One or many of the values of the following: 'permalink', 'the_content',
     *                                   'excerpt', 'custom_fields', 'discussion', 'comments', 'revisions', 'slug',
     *                                   'author', 'format', 'page_attributes', 'featured_image', 'categories', 'tags',
     *                                   'send-trackbacks', 'all'. Note 'all' which will show all elements that
     *                                   ar possible to hide.
     */
    public function setShowOnScreen($element_names)
    {

        $this->doSetHideOnScreen([], $element_names);

    }

    /**
     * Determines the meta box style. Choices of 'default' or 'seamless'
     *
     * @param string $style 'default' or 'seamless'
     */
    public function setStyle($style)
    {

        $this->setSetting('style', $style);

    }

    /**
     * @return array
     */
    public function toAcfArray()
    {

        return array_merge($this->settings, [
            'key' => $this->getKey(),
            'title' => $this->getTitle(),
            'location' => $this->location_rule_groups->toArray(),
            'fields' => parent::toAcfArray(),
        ]);

    }

}
