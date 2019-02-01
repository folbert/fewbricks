<?php

namespace Fewbricks\ACF;

use Fewbricks\DevTools;
use Fewbricks\Exporter;
use Fewbricks\Helpers\Helper;
use Fewbricks\Helpers\Filters;

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
    const HIDE_ON_SCREEN_ITEMS
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
        $this->settings = [];
        $this->init_location_rule_groups();

        parent::__construct($key);

    }

    /**
     * @param FieldGroupLocationRuleGroup $rule_group
     * @return $this
     */
    public function add_location_rule_group($rule_group)
    {

        $this->location_rule_groups->add_item($rule_group);

        return $this;

    }

    /**
     *
     */
    private function init_location_rule_groups()
    {

        $this->clear_location_rule_groups();

    }

    /**
     */
    public function clear_location_rule_groups()
    {

        $this->location_rule_groups = new RuleGroupCollection();

        return $this;

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
     * @param bool $merge_with_current
     */
    private function do_set_hide_on_screen(array $hide_on_screen, array $show_on_screen = [], $merge_with_current = false)
    {

        $current_values = $this->get_hide_on_screen_setting();

        if (!empty($show_on_screen)) {

            // If the user want to show all...
            if ($show_on_screen[0] === 'all') {

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
            if ($hide_on_screen[0] === 'all') {

                $hide_on_screen = self::HIDE_ON_SCREEN_ITEMS;

            } else {

                if (!is_array($hide_on_screen)) {
                    $hide_on_screen = [$hide_on_screen];
                }

                if($merge_with_current) {
                    $hide_on_screen = array_merge($current_values, $hide_on_screen);
                }

            }

        }

        $this->set_setting('hide_on_screen', $hide_on_screen);

    }

    /**
     * ACF setting
     *
     * @return bool|mixed
     */
    public function get_active()
    {

        return $this->get_setting('active', 1);

    }

    /**
     * ACF setting
     *
     * @return bool|mixed
     */
    public function get_description()
    {

        return $this->get_setting('description', '');

    }

    /**
     * ACF setting
     *
     * @return array|bool|mixed
     */
    public function get_hide_on_screen_setting()
    {

        return $this->get_setting('hide_on_screen', []);

    }

    /**
     * ACF Setting
     *
     * @return bool|mixed
     */
    public function get_instruction_placement()
    {

        return $this->get_setting('instruction_placement', 'label');

    }

    /**
     * ACF Setting
     *
     * @return bool|mixed
     */
    public function get_label_placement()
    {

        return $this->get_setting('label_placement', 'top');

    }

    /**
     * @return RuleGroupCollection
     */
    public function get_location_rulegroups()
    {

        return $this->location_rule_groups;

    }

    /**
     * ACF Setting
     *
     * @return bool|mixed
     */
    public function get_menu_order()
    {

        return $this->get_setting('menu_order', 0);

    }

    /**
     * ACF Setting
     *
     * @return bool|mixed
     */
    public function get_position()
    {

        return $this->get_setting('position', 'normal');

    }

    /**
     * Get the value of a specific setting.
     *
     * @param string $name The name of the setting
     * @param mixed $default_value The value to return if the setting does not exist
     *
     * @return bool|mixed
     */
    public function get_setting(string $name, $default_value = 0)
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
    public function get_settings()
    {

        return $this->settings;

    }

    /**
     * ACF Setting
     *
     * @return bool|mixed
     */
    public function get_style()
    {

        return $this->get_setting('style', 'default');

    }

    /**
     * @return string
     */
    public function get_title()
    {

        return $this->title;

    }

    /**
     * Called just before sending field to ACF. This way you can add this function to your own classes extending
     * this class and write any last-minute custom logic to execute right before sending the field group to ACF.
     */
    public function prepare_for_registration()
    {

    }

    /**
     * In order to keep in sync with ACFs namings, we have this function to call publicly. And then use doRegister()
     * to actually register.
     * @param bool $unset_after_added_to_acf
     * @return FieldGroup
     */
    public function register(bool $unset_after_added_to_acf = true)
    {

        $this->prepare_for_registration();

        $acf_settings_array = $this->to_acf_array($this->get_key());

        Exporter::maybe_store_simple_field_group_data($acf_settings_array['title'], $acf_settings_array['key']);
        Exporter::maybe_store_field_group_acf_settings($acf_settings_array);
        DevTools::maybe_store_acf_settings_array_for_dev_display($acf_settings_array);

        acf_add_local_field_group($acf_settings_array);

        if ($unset_after_added_to_acf) {

            // Lets clear up some space
            unset($this->settings);
            unset($this->items);

        } else {

            return $this;

        }

    }

    /**
     * ACF setting. If the field group should be registered or not.
     *
     * @param $active
     * @return $this
     */
    public function set_active($active)
    {

        return $this->set_setting('active', $active);

    }

    /**
     * ACF setting. Shown in field group list. Since this is a setting that only affects the ACF GUI, it will probably
     * never be used by Fewbricks users. But lets add this function anyways just to be nice :)
     *
     * @param string $description The description
     * @return $this
     */
    public function set_description($description)
    {

        return $this->set_setting('description', $description);

    }

    /**
     * @param bool $show
     * @return $this
     */
    public function set_display_in_fewbricks_dev_tools(bool $show)
    {

        return $this->set_setting(DevTools::SETTINGS_NAME_FOR_DISPLAYING_ACF_ARRAY, $show);

    }

    /**
     * @return bool|mixed
     */
    public function get_display_in_fewbricks_dev_tools()
    {

        return $this->get_setting(DevTools::SETTINGS_NAME_FOR_DISPLAYING_ACF_ARRAY, false);

    }

    /**
     * Allow you to set which elements that should be hidden on screen.
     *
     * @see FieldGroup::do_set_hide_on_screen()
     *
     * @param string|array $element_names One or many of the values of the following: 'permalink', 'the_content',
     * 'excerpt', 'custom_fields', 'discussion', 'comments', 'revisions', 'slug', 'author', 'format', 'page_attributes',
     * 'featured_image', 'categories', 'tags', 'send-trackbacks', 'all'. Note 'all' which will hide all elements that
     * are possible to hide.
     * @param bool $merge_with_current Set to true if you want to keep hiding the field already hidden. False means that
     * you will only hide the ones sent.
     * @return $this
     */
    public function set_hide_on_screen($element_names, $merge_with_current = false)
    {

        if(!is_array($element_names)) {
            $element_names = [$element_names];
        }

        $this->do_set_hide_on_screen($element_names, [], $merge_with_current);

        return $this;

    }

    /**
     * ACF Setting. Determines where field instructions are placed in relation to fields.
     *
     * @param string $instruction_placement 'label' (Below labels) or 'field' (Below fields)
     * @return $this
     */
    public function set_instruction_placement($instruction_placement)
    {

        return $this->set_setting('instruction_placement', $instruction_placement);

    }

    /**
     * ACF Setting. Determines where field labels are placed in relation to fields. Defaults to 'top'.
     *
     * @param string $label_placement 'top' (Above fields) or 'left' (Beside fields)
     * @return $this
     */
    public function set_label_placement($label_placement)
    {

        return $this->set_setting('label_placement', $label_placement);

    }

    /**
     * ACF setting. Field groups are shown in order from lowest to highest.
     *
     * @param int $menu_order
     * @return $this
     */
    public function set_menu_order($menu_order)
    {

        return $this->set_setting('menu_order', $menu_order);

    }

    /**
     * ACF setting. Determines the position on the edit screen. Defaults to 'normal'.
     *
     * @param string $position 'acf_after_title', 'normal' or 'side'
     * @return $this
     */
    public function set_position($position)
    {

        return $this->set_setting('position', $position);

    }

    /**
     * Enables you to add values to the settings directly. So if ACF adds new settings, you don't have to wait for
     * Fewbricks to add functions for you to be able to set them.
     *
     * @param string $name
     * @param mixed $value
     * @return $this
     */
    public function set_setting(string $name, $value)
    {

        $class_property_names = ['key', 'title'];

        // Make sure to keep any property names up to date
        if (in_array($name, $class_property_names)) {
            $this->{$name} = $value;
        }

        $this->settings[$name] = $value;

        return $this;

    }

    /**
     * If the element has been previously set to be hidden, this will set it to be shown instead.
     *
     * @see FieldGroup::set_hide_on_screen()
     *
     * @param string|array $element_names One or many of the values of the following: 'permalink', 'the_content',
     * 'excerpt', 'custom_fields', 'discussion', 'comments', 'revisions', 'slug', 'author', 'format', 'page_attributes',
     * 'featured_image', 'categories', 'tags', 'send-trackbacks', 'all'. Note 'all' which will show all elements that
     *  are possible to hide.
     * @return $this
     */
    public function set_show_on_screen($element_names)
    {

        if(!is_array($element_names)) {
            $element_names = [$element_names];
        }

        $this->do_set_hide_on_screen([], $element_names);

        return $this;

    }

    /**
     * Determines the meta box style. Choices of 'default' or 'seamless'
     *
     * @param string $style 'default' or 'seamless'
     * @return $this
     */
    public function set_style($style)
    {

        return $this->set_setting('style', $style);

    }

    /**
     * @param $title
     * @return $this
     */
    public function set_title($title)
    {

        $this->title = $title;

        return $this;

    }

    /**
     * @param array $acf_array
     * @return array
     */
    private function finalize_fields_conditional_logic(array $acf_array)
    {

        // Conditional logic for ACF is made up of a three-levelled array where the first level is the entire logic,
        // the second level are groups (whose relations are OR) and the third level are items (whose relations are AND).

        foreach ($acf_array AS $field_settings_key => $field_settings) {

            // If the field has conditional logic
            if (isset($field_settings['conditional_logic']) &&
                is_array($field_settings['conditional_logic'])
            ) {

                $conditional_logic_groups = $field_settings['conditional_logic'];

                // Traverse down the conditional logic array
                foreach ($conditional_logic_groups AS $conditional_logic_group_key => $conditional_logic_group_value) {

                    foreach (
                        $conditional_logic_groups[$conditional_logic_group_key] AS
                        $conditional_logic_item_key => $conditional_logic_item_value
                    ) {

                        // Retrieve the key for the field to check
                        $target_field_key
                            = $conditional_logic_groups[$conditional_logic_group_key][$conditional_logic_item_key]['field'];

                        // Get the settings for the file.
                        $target_field_settings = Helper::get_field_by_original_key_from_acf_array($target_field_key, $acf_array);

                        if ($target_field_settings !== false) {

                            // Swap the key set in the rule with the key that the field has been given by Fewbricks
                            // after prefixing keys of parent fields and field group to it.
                            $conditional_logic_groups[$conditional_logic_group_key][$conditional_logic_item_key]['field']
                                = $target_field_settings['key'];

                        }

                    }

                }

                $acf_array[$field_settings_key]['conditional_logic'] = $conditional_logic_groups;

            }

            // Traverse down any child fields
            if (isset($field_settings['sub_fields']) && is_array($field_settings['sub_fields'])) {

                $field_settings['sub_fields'] = $this->finalize_fields_conditional_logic($field_settings['sub_fields']);

            } else if (isset($field_settings['layouts']) && is_array($field_settings['layouts'])) {

                $field_settings['layouts'] = $this->finalize_fields_conditional_logic($field_settings['layouts']);

            }

        }

        return $acf_array;

    }

    /**
     * @param string $key_prefix
     * @return array
     */
    public function to_acf_array(string $key_prefix = '')
    {

        $fields = parent::to_acf_array($key_prefix);
        $fields = $this->finalize_fields_conditional_logic($fields);

        if (Filters::dev_mode_is_enabled()) {
            Helper::validate_field_names($fields);
            Helper::validate_unique_keys($fields);
        }

        return array_merge($this->settings, [
            'key' => Helper::get_valid_field_group_key($this->get_key()),
            'title' => $this->get_title(),
            'location' => $this->location_rule_groups->to_array(),
            'fields' => $fields,
        ]);

    }

}
