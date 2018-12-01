<?php

namespace Fewbricks\ACF;

use Fewbricks\DevTools;
use Fewbricks\Helper;

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

        $this->type = $this::TYPE;

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

        return $this->key;

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

        return $this->setSetting(DevTools::getSettingsNameForDisplayingAcfArray(), $display);

    }

    /**
     * @param string $instructions ACF setting. Instructions for authors.
     *                             Shown when submitting data
     * @return $this
     */
    public function setInstructions($instructions)
    {

        return $this->setSetting('instructions', $instructions);

    }

    /**
     * @param boolean $required ACF setting. Whether or not the field value
     *                              is required. If not set, false is used.
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
     * @param array $extraSettings Any extra settings that you want to apply at the last minute. Be careful not to set
     *                             crucial settings like "key" and "conditional_logic" here. We will not remove any
     *                             such items from the array in case you really want to set them,
     *
     * @return array
     */
    public function toAcfArray(array $extraSettings = [])
    {

        $settings = parent::toAcfArray();

        $settings['key'] = Helper::maybePrefixFieldKey($settings['key']);

        $settings = array_merge($settings, [
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
