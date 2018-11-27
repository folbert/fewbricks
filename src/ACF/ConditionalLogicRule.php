<?php

namespace Fewbricks\ACF;

/**
 * Class ConditionalLogicRule
 *
 * @package Fewbricks\ACF
 */
class ConditionalLogicRule extends Rule
{

    /**
     * @return array An array that ACF can work with.
     */
    public function toAcfArray()
    {

        return [
            'field' => $this->getParam(),
            'operator' => $this->getOperator(),
            'value' => $this->getValue()
        ];

    }

}
