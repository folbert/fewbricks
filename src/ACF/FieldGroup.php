<?php

namespace Fewbricks\ACF;

use Fewbricks\DevTools;
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
    protected $title = 'Field Group';

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
    public function addLocationRuleGroup($rule_group)
    {

        $this->location_rule_groups->addItem($rule_group);

    }

    /**
     * @param FieldGroupLocationRuleGroup[] $rule_groups
     */
    public function addLocationRuleGroups($rule_groups)
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
     * Possible values in the array: 'permalink', 'the_content', 'excerpt', 'custom_fields', 'discussion',
     * 'comments', 'revisions', 'slug', 'author', 'format', 'page_attributes', 'featured_image', 'categories',
     * 'tags', 'send-trackbacks', 'all'
     *
     * @param array $hide_on_screen Array with items to hide on the screen.
     * @param array $show_on_screen Fewbricks addition. Enables you to define which fields should be visible on screen.
     *                            This will create an array with all the items that ACF supports hiding and then
     *                            remove the items that you have set in $showOnScreen. Passing a non-empty value here
     *                            will make the function ignore the $hideOnScreen variable completely
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
     * @param null $default_value
     *
     * @return bool|mixed
     */
    public function getActive($default_value = null)
    {

        return $this->getSetting('active', $default_value);

    }

    /**
     * @return string
     */
    public function getBaseKey()
    {

        return $this->getKey();

    }

    /**
     * @param string $default_value
     *
     * @return bool|mixed
     */
    public function getDescription($default_value = '')
    {

        return $this->getSetting('description', $default_value);

    }

    /**
     * @return array|bool|mixed
     */
    public function getHideOnScreenSetting()
    {

        // These are the items that ACF supports hiding as of v5.6.5
        $current_values = $this->getSetting('hide_on_screen', []);

        return $current_values;

    }

    /**
     * @param bool $default_value
     *
     * @return bool|mixed
     */
    public function getInstructionPlacement($default_value = false)
    {

        return $this->getSetting('instruction_placement', $default_value);

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
     * @param $default_value
     *
     * @return bool|mixed
     */
    public function getLabelPlacement($default_value)
    {

        return $this->getSetting('label_placement', $default_value);

    }

    /**
     * @return RuleGroupCollection
     */
    public function getLocationRulegroups()
    {

        return $this->location_rule_groups;

    }

    /**
     * @param $default_value
     *
     * @return bool|mixed
     */
    public function getMenuOrder($default_value)
    {

        return $this->getSetting('menu_order', $default_value);

    }

    /**
     * @param $default_value
     *
     * @return bool|mixed
     */
    public function getPosition($default_value)
    {

        return $this->getSetting('position', $default_value);

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
     * @param mixed $default_value
     *
     * @return bool|mixed
     */
    public function getStyle($default_value = false)
    {

        return $this->getSetting('style', $default_value);

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
     * @return mixed|void
     */
    public function prepareForRegistration()
    {

    }

    /**
     * In order to keep in sync with ACFs namings, we have this function to call publicly. And then use doRegister()
     * to actually register.
     */
    public function register()
    {

        $this->prepareForRegistration();

        $acf_settings_array = $this->toAcfArray();

        Helper::maybeStoreSimpleFieldGroupData($acf_settings_array['title'], $acf_settings_array['key']);
        Helper::maybeStoreFieldGroupAcfSettings($acf_settings_array);
        DevTools::maybeStoreAcfSettingsArrayForDevDisplay($acf_settings_array);

        acf_add_local_field_group($acf_settings_array);

        // No use in having a potentially large collection of objects anymore
        unset($this->items);

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
