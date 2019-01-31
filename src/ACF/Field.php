<?php

namespace Fewbricks\ACF;

use Fewbricks\Brick;
use Fewbricks\DevTools;
use Fewbricks\Helpers\Helper;

/**
 * Class Field
 *
 * @package Fewbricks\ACF
 */
class Field
{

    /**
     * @var RuleGroupCollection
     */
    private $conditionalLogicRuleGroups;

    /**
     * @var string The key required by ACF. Must be unique across the site.
     */
    protected $key;

    /**
     * @var
     */
    protected $keyPrefix;

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
     * @var string The key of the parent, if any, that this item is part of.
     */
    private $parents;

    /**
     * The array that makes up the field.
     * https://www.advancedcustomfields.com/resources/register-fields-via-php/#field-settings
     *
     * @var array
     */
    protected $settings;

    /**
     * @var
     */
    protected $type;

    /**
     * Field constructor.
     *
     * @param string $label The label of the field
     * @param string $name The name of the field
     * @param string $key The key of the field. Must be unique across the entire app
     */
    public function __construct(string $label, string $name, string $key)
    {

        // Lets keep these crucial settings as class vars to make them easier and nicer to access.
        $this->type = static::TYPE;
        $this->label = $label;
        $this->name = $name;
        $this->key = $key;
        $this->keyPrefix = '';
        $this->originalKey = $key;
        $this->parents = [];

        $this->clear_conditional_logic();

    }

    /**
     * @return mixed The value of the ACF setting "default_value". Returns the default ACF value "" if none has been set
     * using Fewbricks.
     */
    public function get_default_value()
    {

        return $this->get_setting('default_value', '');

    }

    /**
     * @param mixed $defaultValue ACF setting. A default value used by ACF if no value has yet been saved.
     * @return $this
     */
    public function set_default_value($defaultValue)
    {

        return $this->set_setting('default_value', $defaultValue);

    }

    /**
     * @param bool $display
     * @return $this
     */
    public function set_display_in_fewbricks_dev_tools(bool $display)
    {

        return $this->set_setting(DevTools::SETTINGS_NAME_FOR_DISPLAYING_ACF_ARRAY, $display);

    }

    /**
     * @return $this
     */
    public function get_display_in_fewbricks_dev_tools()
    {

        return $this->get_setting(DevTools::SETTINGS_NAME_FOR_DISPLAYING_ACF_ARRAY, false);

    }

    /**
     * @param string $instructions ACF setting. Instructions for authors. Shown when submitting data
     * @return $this
     */
    public function set_instructions($instructions)
    {

        return $this->set_setting('instructions', $instructions);

    }

    /**
     * @param $originalKey
     */
    protected function set_original_key(string $originalKey)
    {

        $this->originalKey = $originalKey;

    }

    /**
     * @param string $key
     * @param string $name
     * @param string $type
     */
    public function add_parent(string $key, string $name, string $type)
    {

        $this->parents[] = [
            'key' => $key,
            'name' => $name,
            'type' => $type,
        ];

    }

    /**
     * @param bool $required ACF setting. Whether or not the field value is required. If not set, false is used.
     * @return $this
     */
    public function set_required($required)
    {

        return $this->set_setting('required', $required);

    }

    /**
     * @param array $wrapper ACF setting. An array of attributes given to the field element in the backend.
     * Indexes in the array can be 'width', 'class' and 'id'.
     * @return $this
     */
    public function set_wrapper(array $wrapper)
    {

        // Make sure all indexes are set.
        $wrapper = array_merge([
            'width' => '',
            'class' => '',
            'id' => '',
        ], $wrapper);

        return $this->set_setting('wrapper', $wrapper);

    }

    /**
     * Allows you to set multiple settings at once.
     *
     * @param array $settings
     * @return $this
     */
    public function set_settings(array $settings)
    {

        foreach ($settings AS $name => $value) {

            $this->set_setting($name, $value);

        }

        return $this;

    }

    /**
     * @param string $name
     * @param mixed $value
     * @return $this
     */
    public function set_setting(string $name, $value)
    {

        $classPropertyNames = ['key', 'label', 'name', 'type'];

        // Make sure to keep any class property names up to date
        if (in_array($name, $classPropertyNames)) {
            $this->{$name} = $value;
        }

        $this->settings[$name] = $value;

        return $this;

    }


    /**
     * @return $this
     */
    public function clear_conditional_logic()
    {

        $this->conditionalLogicRuleGroups = new RuleGroupCollection();

        return $this;

    }

    /**
     * @param ConditionalLogicRuleGroup[] $ruleGroups
     * @return $this
     */
    public function add_conditional_logic_rule_groups($ruleGroups)
    {

        foreach ($ruleGroups AS $ruleGroup) {

            $this->add_conditional_logic_rule_group($ruleGroup);

        }

        return $this;

    }

    /**
     * @param ConditionalLogicRuleGroup $ruleGroup
     * @return $this
     */
    public function add_conditional_logic_rule_group($ruleGroup)
    {

        $this->conditionalLogicRuleGroups->add_item($ruleGroup);

        return $this;

    }

    /**
     * @return mixed The value of the ACF setting "conditional_logic". Returns the default ACF value 0 if none
     * has been set using Fewbricks.
     */
    public function get_conditional_logic()
    {

        return $this->get_setting('conditional_logic', 0);

    }

    /**
     * @return RuleGroupCollection
     */
    public function get_conditional_logic_rule_groups()
    {

        return $this->conditionalLogicRuleGroups;

    }

    /**
     * @param string $keyPrefix
     * @return string
     */
    public function get_final_key(string $keyPrefix = '')
    {

        if(!empty($keyPrefix)) {
            $keyPrefix .= '_';
        }

        $keyPrefix .= $this->get_key_prefix_from_parents();

        return Helper::get_valid_field_key($keyPrefix . $this->get_key());

    }

    /**
     * @return string
     */
    public function get_key_prefix_from_parents()
    {

        $keyPrefix = '';

        $parents = $this->get_parents(true);

        foreach($parents AS $parent) {

            if($parent['type'] === Brick::CLASS_ID_STRING) {
                $keyPrefix .= $parent['key'] . '_';
            }

        }

        return $keyPrefix;

    }

    /**
     * @return string
     */
    public function get_final_name()
    {

        $namePrefix = '';

        $parents = $this->get_parents(true);

        foreach($parents AS $parent) {

            if($parent['type'] === Brick::CLASS_ID_STRING) {
                $namePrefix .= $parent['name'] . '_';
            }

        }

        return $namePrefix . $this->name;

    }

    /**
     * @return mixed The value of the ACF setting "instructions". Returns the default ACF value if none has been set
     * using
     * Fewbricks.
     */
    public function get_instructions()
    {

        return $this->get_setting('instructions', '');

    }

    /**
     * @return string
     */
    public function get_key()
    {

        return $this->key;

    }

    /**
     * @return mixed The value of the ACF setting "required". Returns the default ACF value 0 if none has been set
     * using Fewbricks.
     */
    public function get_required()
    {

        return $this->get_setting('required', 0);

    }

    /**
     * @return string The ACF field type that this field is
     */
    public function get_type()
    {

        return $this->type;

    }

    /**
     * @return mixed The value of the ACF setting "wrapper". Returns the default ACF value if none has been set using
     * Fewbricks.
     */
    public function get_wrapper()
    {

        return $this->get_setting('wrapper', []);

    }



    /**
     * @return string
     */
    public function get_label()
    {

        return $this->label;

    }

    /**
     * @return string
     */
    public function get_name()
    {

        return $this->name;

    }

    /**
     * @return string
     */
    public function get_original_key()
    {

        return $this->originalKey;

    }

    /**
     * @param bool $reverseOrder
     * @return array
     */
    public function get_parents(bool $reverseOrder = false)
    {

        $parents = $this->parents;

        if($reverseOrder) {
            $parents = array_reverse($parents);
        }

        return $parents;

    }

    /**
     * Get the value of a specific setting. Please note that you can only
     * get the settings that you have set when creating the instance.
     * Any default values that are set by ACF and that has not been overridden
     * in this instance will return the $defaultValue
     *
     * @param string $name The name of the setting to get
     * @param mixed $defaultValue Value to return if setting is not set
     *
     * @return mixed $defaultValue if value was not found, otherwise the value
     */
    public function get_setting(string $name, $defaultValue = false)
    {

        $value = $defaultValue;

        if (isset($this->settings[$name])) {

            $value = $this->settings[$name];

        }

        return $value;

    }

    /**
     * @param string $prefix
     * @return $this
     */
    public function prefix_key(string $prefix)
    {

        $this->key = $prefix . $this->key;

        return $this;

    }

    /**
     * @param string $prefix
     * @return $this
     */
    public function prefix_label(string $prefix)
    {

        $this->label = $prefix . $this->label;

        return $this;

    }

    /**
     * @param string $prefix
     * @return $this
     */
    public function prefix_name(string $prefix)
    {

        $this->name = $prefix . $this->name;

        return $this;

    }

    /**
     * @param string $suffix
     * @return $this
     */
    public function suffix_label(string $suffix)
    {

        $this->label .= $suffix;

        return $this;

    }

    /**
     * Empty to allow overriding but not requiring implementing in every field.
     */
    protected function prepare_for_acf_array()
    {

    }

    /**
     * @param string $keyPrefix
     *
     * @return array
     */
    public function to_acf_array(string $keyPrefix = '')
    {

        $this->prepare_for_acf_array();

        $settings = $this->settings;
        $settings['key'] =  $this->get_final_key($keyPrefix);
        $settings['label'] = $this->label;
        $settings['name'] = $this->name;
        $settings['name'] = $this->get_final_name();

        $settings = array_merge($settings, [
            'fewbricks__original_key' => $this->get_original_key(),
            'fewbricks__parents' => $this->get_parents(),
            'type' => $this->get_type(),
        ]);

        if (!$this->conditionalLogicRuleGroups->is_empty()) {

            $settings['conditional_logic'] = $this->conditionalLogicRuleGroups->to_array();

        }

        return $settings;

    }

}
