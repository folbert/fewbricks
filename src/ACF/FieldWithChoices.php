<?php

namespace Fewbricks\ACF;

/**
 * Class FieldWithChoices
 *
 * @package Fewbricks\ACF
 */
class FieldWithChoices extends Field
{

    /**
     * @return mixed The value of the ACF setting "choices". Returns the default ACF value of an empty array if none has
     * been set using Fewbricks.
     */
    public function getChoices()
    {

        return $this->getSetting('choices', []);

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
     * @return mixed The value of the ACF setting "return_format". Returns the default ACF value "value" if none has
     * been set using Fewbricks.
     */
    public function getReturnFormat()
    {

        return $this->getSetting('return_format', 'value');

    }

    /**
     * ACF setting.
     *
     * @param array $choices Associative array with options. Key will be name and value will be value.
     * @return $this
     */
    public function setChoices($choices)
    {

        return $this->setSetting('choices', $choices);

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
     * ACF setting. Specify the returned value on front end.
     *
     * @param $returnFormat "value", "label" or "array" (for both)
     * @return $this
     */
    public function setReturnFormat($returnFormat)
    {

        return $this->setSetting('return_format', $returnFormat);

    }

}
