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

        $this->clearConditionalLogic();

    }

    /**
     * @return mixed The value of the ACF setting "default_value". Returns the default ACF value "" if none has been set
     * using Fewbricks.
     */
    public function getDefaultValue()
    {

        return $this->getSetting('default_value', '');

    }

    /**
     * @param mixed $defaultValue ACF setting. A default value used by ACF if no value has yet been saved.
     * @return $this
     */
    public function setDefaultValue($defaultValue)
    {

        return $this->setSetting('default_value', $defaultValue);

    }

    /**
     * @param bool $display
     * @return $this
     */
    public function setDisplayInFewbricksDevTools(bool $display)
    {

        return $this->setSetting(DevTools::SETTINGS_NAME_FOR_DISPLAYING_ACF_ARRAY, $display);

    }

    /**
     * @return $this
     */
    public function getDisplayInFewbricksDevTools()
    {

        return $this->getSetting(DevTools::SETTINGS_NAME_FOR_DISPLAYING_ACF_ARRAY, false);

    }

    /**
     * @param string $instructions ACF setting. Instructions for authors. Shown when submitting data
     * @return $this
     */
    public function setInstructions($instructions)
    {

        return $this->setSetting('instructions', $instructions);

    }

    /**
     * @param $originalKey
     */
    protected function setOriginalKey(string $originalKey)
    {

        $this->originalKey = $originalKey;

    }

    /**
     * @param string $key
     * @param string $name
     * @param string $type
     */
    public function addParent(string $key, string $name, string $type)
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
    public function setRequired($required)
    {

        return $this->setSetting('required', $required);

    }

    /**
     * @param array $wrapper ACF setting. An array of attributes given to the field element in the backend.
     * Indexes in the array can be 'width', 'class' and 'id'.
     * @return $this
     */
    public function setWrapper(array $wrapper)
    {

        // Make sure all indexes are set.
        $wrapper = array_merge([
            'width' => '',
            'class' => '',
            'id' => '',
        ], $wrapper);

        return $this->setSetting('wrapper', $wrapper);

    }

    /**
     * Allows you to set multiple settings at once.
     *
     * @param array $settings
     * @return $this
     */
    public function setSettings(array $settings)
    {

        foreach ($settings AS $name => $value) {

            $this->setSetting($name, $value);

        }

        return $this;

    }

    /**
     * @param string $name
     * @param mixed $value
     * @return $this
     */
    public function setSetting(string $name, $value)
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
    public function clearConditionalLogic()
    {

        $this->conditionalLogicRuleGroups = new RuleGroupCollection();

        return $this;

    }

    /**
     * @param ConditionalLogicRuleGroup[] $ruleGroups
     * @return $this
     */
    public function addConditionalLogicRuleGroups($ruleGroups)
    {

        foreach ($ruleGroups AS $ruleGroup) {

            $this->addConditionalLogicRuleGroup($ruleGroup);

        }

        return $this;

    }

    /**
     * @param ConditionalLogicRuleGroup $ruleGroup
     * @return $this
     */
    public function addConditionalLogicRuleGroup($ruleGroup)
    {

        $this->conditionalLogicRuleGroups->addItem($ruleGroup);

        return $this;

    }

    /**
     * @return mixed The value of the ACF setting "conditional_logic". Returns the default ACF value 0 if none
     * has been set using Fewbricks.
     */
    public function getConditionalLogic()
    {

        return $this->getSetting('conditional_logic', 0);

    }

    /**
     * @return RuleGroupCollection
     */
    public function getConditionalLogicRuleGroups()
    {

        return $this->conditionalLogicRuleGroups;

    }

    /**
     * @param string $keyPrefix
     * @return string
     */
    private function getFinalKey(string $keyPrefix = '')
    {

        if(!empty($keyPrefix)) {
            $keyPrefix .= '_';
        }

        $keyPrefix .= $this->getKeyPrefixFromParents();

        return Helper::getValidFieldKey($keyPrefix . $this->getKey());

    }

    /**
     * @return string
     */
    public function getKeyPrefixFromParents()
    {

        $keyPrefix = '';

        $parents = $this->getParents(true);

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
    private function getFinalName()
    {

        $namePrefix = '';

        $parents = $this->getParents(true);

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
    public function getInstructions()
    {

        return $this->getSetting('instructions', '');

    }

    /**
     * @return string
     */
    public function getKey()
    {

        return $this->key;

    }

    /**
     * @return mixed The value of the ACF setting "required". Returns the default ACF value 0 if none has been set
     * using Fewbricks.
     */
    public function getRequired()
    {

        return $this->getSetting('required', 0);

    }

    /**
     * @return string The ACF field type that this field is
     */
    public function getType()
    {

        return $this->type;

    }

    /**
     * @return mixed The value of the ACF setting "wrapper". Returns the default ACF value if none has been set using
     * Fewbricks.
     */
    public function getWrapper()
    {

        return $this->getSetting('wrapper', []);

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
     * @param bool $reverseOrder
     * @return array
     */
    public function getParents(bool $reverseOrder = false)
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
    public function getSetting(string $name, $defaultValue = false)
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
    public function prefixKey(string $prefix)
    {

        $this->key = $prefix . $this->key;

        return $this;

    }

    /**
     * @param string $prefix
     * @return $this
     */
    public function prefixLabel(string $prefix)
    {

        $this->label = $prefix . $this->label;

        return $this;

    }

    /**
     * @param string $prefix
     * @return $this
     */
    public function prefixName(string $prefix)
    {

        $this->name = $prefix . $this->name;

        return $this;

    }

    /**
     * @param string $suffix
     * @return $this
     */
    public function suffixLabel(string $suffix)
    {

        $this->label .= $suffix;

        return $this;

    }

    /**
     * Empty to allow overriding but not requiring implementing in every field.
     */
    protected function prepareForAcfArray()
    {

    }

    /**
     * @param string $keyPrefix
     *
     * @return array
     */
    public function toAcfArray(string $keyPrefix = '')
    {

        $this->prepareForAcfArray();

        $settings = $this->settings;
        $settings['key'] =  $this->getFinalKey($keyPrefix);
        $settings['label'] = $this->label;
        $settings['name'] = $this->name;
        $settings['name'] = $this->getFinalName();

        $settings = array_merge($settings, [
            'fewbricks__original_key' => $this->getOriginalKey(),
            'fewbricks__parents' => $this->getParents(),
            'type' => $this->getType(),
        ]);

        if (!$this->conditionalLogicRuleGroups->isEmpty()) {

            $settings['conditional_logic'] = $this->conditionalLogicRuleGroups->toArray();

        }

        return $settings;

    }

}
