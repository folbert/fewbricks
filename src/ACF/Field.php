<?php

namespace Fewbricks\ACF;

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
     * @param string $label    The label of the field
     * @param string $name     The name of the field
     * @param string $key      The key of the field. Must be unique across the entire app
     * @param array  $settings Array where you can pass all/any of the possible settings for the field.
     *                         https://www.advancedcustomfields.com/resources/register-fields-via-php/#field-type%20settings
     * @param string $type     Name of a valid ACF field type. Makes it possible to create custom field types.
     */
    public function __construct($label, $name, $key, $settings = [], $type = '')
    {

        parent::__construct($label, $name, $key, $settings);

        if (!empty($type)) {
            $this->setType($type);
        }

        $this->clearConditionalLogic();

    }

    /**
     * @param ConditionalLogicRuleGroup $ruleGroup
     *
     * @return $this
     * @throws \Fewbricks\KeyInUseException
     */
    public function addConditionalLogicRuleGroup($ruleGroup)
    {

        $this->conditionalLogicRuleGroups->addItem($ruleGroup);

        return $this;

    }

    /**
     * @param ConditionalLogicRuleGroup[] $ruleGroups
     *
     * @return $this
     * @throws \Fewbricks\KeyInUseException
     */
    public function addConditionalLogicRuleGroups($ruleGroups)
    {

        foreach ($ruleGroups AS $ruleGroup) {

            $this->addConditionalLogicRuleGroup($ruleGroup);

        }

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
     * @return array
     */
    public function getAcfArray()
    {

        $settings = array_merge(parent::getAcfArray(), [
            'fewbricks_original_key' => $this->getOriginalKey(),
            'type'                   => $this->getType(),
        ]);

        if (!$this->conditionalLogicRuleGroups->isEmpty()) {

            $settings['conditional_logic'] = $this->conditionalLogicRuleGroups->toArray();

        }

        return $settings;

    }

    /**
     * @return mixed The value of the ACF setting "conditional_logic". Returns the default ACF value "false" if none has been set
     * using Fewbricks.
     */
    public function getConditionalLogic()
    {

        $this->getSetting('conditional_logic', 0);

        return $this;

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
     * @return The|string
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
     * using
     * Fewbricks.
     */
    public function getRequired()
    {

        return $this->getSetting('required', false);

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
     *
     * @return Field
     */
    public function setType($type)
    {

        $this->type = $type;

        return $this;

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
     *
     * @return $this
     */
    public function setDefaultValue($defaultValue)
    {

        $this->setSetting('default_value', $defaultValue);

        return $this;

    }

    /**
     * @param string $instructions ACF setting. Instructions for authors.
     *                             Shown when submitting data
     *
     * @return $this
     */
    public function setInstructions($instructions)
    {

        $this->setSetting('instructions', $instructions);

        return $this;

    }

    /**
     * @param boolean $required     ACF setting. Whether or not the field value
     *                              is required. If not set, false is used.
     *
     * @return $this
     */
    public function setRequired($required)
    {

        $this->setSetting('required', $required);

        return $this;

    }

    /**
     * @param boolean $wrapper ACF setting. An array of attributes given to the
     *                         field element in the backend.
     *
     * @return $this
     */
    public function setWrapper($wrapper)
    {

        // Make sure all indexes are set.
        $wrapper = array_merge([
            'width' => '',
            'class' => '',
            'id'    => '',
        ], $wrapper);

        $this->setSetting('wrapper', $wrapper);

        return $this;

    }

}
