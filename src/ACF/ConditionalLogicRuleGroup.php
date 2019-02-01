<?php

namespace Fewbricks\ACF;

use Fewbricks\Helpers\Helper;

/**
 * Class ConditionalLogicRuleGroup
 *
 * @package Fewbricks\ACF
 */
class ConditionalLogicRuleGroup extends RuleGroup
{

    /**
     * @param ConditionalLogicRule $rule
     * @return $this
     */
    public function add_conditional_logic_rule($rule)
    {

        if (!($rule instanceof ConditionalLogicRule)) {
            Helper::fewbricks_die('You can only add instances of ConditionalLogicRule to ConditionalLogicRuleGroup');
        }

        parent::add_rule($rule);

        return $this;

    }

}
