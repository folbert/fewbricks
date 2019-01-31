<?php

namespace Fewbricks\ACF;

use Fewbricks\Collection;

/**
 * Class RuleCollection
 *
 * @package Fewbricks\ACF
 */
class RuleCollection extends Collection
{

    /**
     * @return array An array that ACF can work with.
     */
    public function to_acf_array()
    {

        $array = [];

        /** @var Rule $rule */
        foreach ($this->items AS $rule) {

            $array[] = $rule->to_acf_array();

        }

        return $array;

    }

}
