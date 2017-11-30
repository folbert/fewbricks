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
     * Get an
     * @return array
     */
    public function toArray()
    {

        $array = [];

        /** @var FieldGroupLocationRuleGroup $ruleGroup */
        foreach($this->items AS $ruleGroup) {

            $array[] = $ruleGroup->toArray();

        }

        return $array;

    }

}
