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
    public function to_acf_array()
    {

        return [
            'field' => $this->get_param(),
            'operator' => $this->get_operator(),
            'value' => $this->get_value()
        ];

    }

}
