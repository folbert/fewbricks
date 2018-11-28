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
     * @return mixed The value of the ACF setting "allow_null". Returns the default ACF value of an empty array if none has
     * been set using Fewbricks.
     */
    public function getAllowNull()
    {

        return $this->getSetting('allow_null', false);

    }

    /**
     * @return mixed The value of the ACF setting "choices". Returns the default ACF value of an empty array if none has
     * been set using Fewbricks.
     */
    public function getChoices()
    {

        return $this->getSetting('choices', []);

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
     * @param bool $allowNull
     * @return $this
     */
    public function setAllowNull(bool $allowNull)
    {

        return $this->setSetting('allow_null', $allowNull);


    }

    /**
     * ACF setting.
     *
     * @param array $choices Associative array with options. Key will be name and value will be value.
     * @return $this
     */
    public function setChoices(array $choices)
    {

        return $this->setSetting('choices', $choices);

    }

    /**
     * ACF setting. Specify the returned value on front end.
     *
     * @param $returnFormat "value", "label" or "array" (for both)
     * @return $this
     */
    public function setReturnFormat(string $returnFormat)
    {

        return $this->setSetting('return_format', $returnFormat);

    }

}
