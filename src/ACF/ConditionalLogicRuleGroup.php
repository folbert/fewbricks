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
    public function addConditionalLogicRule($rule)
    {

        if (!($rule instanceof ConditionalLogicRule)) {
            Helper::fewbricksDie('You can only add instances of ConditionalLogicRule to ConditionalLogicRuleGroup');
        }

        parent::addRule($rule);

        return $this;

    }

}
