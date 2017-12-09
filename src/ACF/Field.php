<?php

namespace Fewbricks\ACF;

use Fewbricks\ACF\Item;

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
     * Field constructor.
     *
     * @param string $label    The label of the field
     * @param string $name     The name of the field
     * @param string $key      The key of the field. Must be unique across the
     *                         entire app
     * @param array  $settings Array where you can pass all the possible
     *                         settings for the field.
     *                         https://www.advancedcustomfields.com/resources/register-fields-via-php/#field-type%20settings
     * @param string $type     Name of a valid ACF field type
     */
    public function __construct($label, $name, $key, $settings = [], $type = '')
    {

        parent::__construct($label, $name, $key, $settings);

        // @todo Make sure that $type is declared
        if(!empty($type))
        {
            $this->setType($type);
        }

    }

    /**
     * @param array $conditionalLogic ACF setting. Conditionally hide or show
     *                                this field based on other field's values.
     *                                Best to use the ACF UI and export to
     *                                understand the array structure.
     *
     * @return $this
     */
    public function setConditionalLogic($conditionalLogic)
    {

        $this->setSetting('conditional_logic', $conditionalLogic);

        return $this;

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
     * @return mixed The value of the ACF setting "wrapper". Returns the default ACF value if none has been set using
     * Fewbricks.
     */
    public function getWrapper()
    {

        return $this->getSetting('wrapper', []);

    }

    /**
     * @return array
     */
    public function toAcfArray()
    {

        $settings         = parent::toAcfArray();
        $settings['type'] = $this->getType();

        return $settings;

    }

}
