<?php

namespace Fewbricks\ACF\Fields;

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

        $this->setSetting('allow_null', $allowNull);

        return $this;


    }

    /**
     * ACF setting.
     *
     * @param array $choices
     *
     * @return $this
     */
    public function setChoices($choices)
    {

        $this->setSetting('choices', $choices);

        return $this;

    }

    /**
     * ACF setting. Specify the returned value on front end.
     *
     * @param $returnValue value, label or array
     *
     * @return $this
     */
    public function setReturnValue($returnValue)
    {

        $this->setSetting('return_value', $returnValue);

        return $this;

    }

}
