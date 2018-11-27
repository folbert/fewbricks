<?php

namespace Fewbricks\ACF;

use Fewbricks\DevTools;

/**
 * Class Field
 *
 * @package Fewbricks\ACF
 */
class Field extends Item
{

    /**
     * @var
     */
    protected $type;

    /**
     * @var RuleGroupCollection
     */
    private $conditionalLogicRuleGroups;

    /**
     * Field constructor.
     *
     * @param string $label The label of the field
     * @param string $name The name of the field
     * @param string $key The key of the field. Must be unique across the entire app
     */
    public function __construct($label, $name, $key)
    {

        parent::__construct($label, $name, $key);

        $this->type = static::$myType;

        $this->clearConditionalLogic();

    }

    /**
     * @return string The ACF field type that this field is
     */
    public function getType()
    {

        return $this->type;

    }

    /**
     * @param $type
     */
    public function setType($type)
    {

        $this->type = $type;

    }

    /**
     */
    public function clearConditionalLogic()
    {

        $this->conditionalLogicRuleGroups = new RuleGroupCollection();

    }

    /**
     * @param ConditionalLogicRuleGroup[] $ruleGroups
     */
    public function addConditionalLogicRuleGroups($ruleGroups)
    {

        foreach ($ruleGroups AS $ruleGroup) {

            $this->addConditionalLogicRuleGroup($ruleGroup);

        }

    }

    /**
     * @param ConditionalLogicRuleGroup $ruleGroup
     */
    public function addConditionalLogicRuleGroup($ruleGroup)
    {

        $this->conditionalLogicRuleGroups->addItem($ruleGroup);

    }

    /**
     * @return mixed The value of the ACF setting "conditional_logic". Returns the default ACF value "false" if none
     *     has been set using Fewbricks.
     */
    public function getConditionalLogic()
    {

        return $this->getSetting('conditional_logic', false);

    }

    /**
     * @return RuleGroupCollection
     */
    public function getConditionalLogicRuleGroups()
    {

        return $this->conditionalLogicRuleGroups;

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

        $key = $this->key;

        // Lets make sure that the key is ok for ACF
        // https://www.advancedcustomfields.com/resources/register-fields-via-php/#field-settings
        if (substr($key, 0, 6) !== 'field_') {
            $key = 'field_' . $key;
        }

        return $key;

    }

    /**
     * @return mixed The value of the ACF setting "required". Returns the default ACF value false if none has been set
     * using Fewbricks.
     */
    public function getRequired()
    {

        return $this->getSetting('required', false);

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
     * @param mixed $defaultValue ACF setting. A default value used by ACF if no
     *                            value has yet been saved.
     */
    public function setDefaultValue($defaultValue)
    {

        $this->setSetting('default_value', $defaultValue);

    }

    /**
     * @param bool $display
     */

    public function setDisplayInFewbricksDevTools(bool $display)
    {

        $this->setSetting(DevTools::getSettingsNameForDisplayingAcfArray(), $display);

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
     * @param boolean $required ACF setting. Whether or not the field value
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
            'id' => '',
        ], $wrapper);

        $this->setSetting('wrapper', $wrapper);

    }

    /**
     * @param array $extraSettings Any extra settings that you want to apply at the last minute. Be careful not to set
     *                             crucial settings like "key" and "conditional_logic" here. We will not remove any
     *                             such items from the array in case you really want to set them,
     *
     * @return array
     */
    public function toAcfArray(array $extraSettings = [])
    {

        $settings = array_merge(parent::toAcfArray(), [
            'fewbricks__original_key' => $this->getOriginalKey(),
            'fewbricks__brick_key' => $this->getParentBrickKey(),
            'fewbricks__brick_name' => $this->getParentBrickName(),
            'type' => $this->getType(),
        ]);

        if (!$this->conditionalLogicRuleGroups->isEmpty()) {

            $settings['conditional_logic'] = $this->conditionalLogicRuleGroups->toArray();

        }

        $settings = array_merge($settings, $extraSettings);

        return $settings;

    }

}
