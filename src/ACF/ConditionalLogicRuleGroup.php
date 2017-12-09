<?php

namespace Fewbricks\ACF;

/**
 * Class ConditionalLogicRuleGroup
 *
 * @package Fewbricks\ACF
 */
class ConditionalLogicRuleGroup extends RuleGroup
{

    /**
     * @param ConditionalLogicRule $rule
     *
     * @return $this
     */
    public function addRule($rule)
    {

        if(!($rule instanceof ConditionalLogicRule)) {
            wp_die('You can only add instances of ConditionalLogicRule to instances of ConditionalLogicRuleGroup');
        }

        parent::addRule($rule);

        return $this;
    }


}
