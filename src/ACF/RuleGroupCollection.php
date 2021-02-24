<?php

namespace Fewbricks\ACF;

use Fewbricks\Collection;

/**
 * Class RuleGroupCollection
 *
 * The relation between each rule group is "or"
 *
 * @package Fewbricks\ACF
 */
class RuleGroupCollection extends Collection
{

    /**
     * @return array An array that ACF can work with.
     */
    public function to_array()
    {

        $array = [];

        /** @var FieldGroupLocationRuleGroup $rule_group */
        foreach ($this->items AS $rule_group) {

            $array[] = $rule_group->to_acf_array();

        }

        return $array;

    }

}
