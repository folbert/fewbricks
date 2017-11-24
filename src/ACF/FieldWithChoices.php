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
     * ACF setting.
     *
     * @param $allowNull
     *
     * @return $this
     */
    public function setAllowNull($allowNull)
    {

        return $this->setSetting('allow_null', $allowNull);


    }

    /**
     * ACF setting.
     *
     * @param array $choices Associative array with options. Key will be name and value will be value.
     *
     * @return $this
     */
    public function setChoices($choices)
    {

        return $this->setSetting('choices', $choices);

    }

    /**
     * ACF setting. Specify the returned value on front end.
     *
     * @param $returnValue "value", "label" or "array"
     *
     * @return $this
     */
    public function setReturnValue($returnValue)
    {

        return $this->setSetting('return_value', $returnValue);

    }

}
