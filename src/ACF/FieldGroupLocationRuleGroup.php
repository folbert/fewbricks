<?php

namespace Fewbricks\ACF;

/**
 * Class FieldGroupLocationRuleGroup
 *
 * @package Fewbricks\ACF
 */
class FieldGroupLocationRuleGroup extends RuleGroup
{

    /**
     * @param FieldGroupLocationRule $rule
     * @return $this
     */
    public function addFieldGroupLocationRule(FieldGroupLocationRule $rule)
    {

        if (!($rule instanceof FieldGroupLocationRule)) {
            wp_die('You can only add instances of FieldGroupLocationRule to FieldGroupLocationRuleGroup');
        }

        parent::addRule($rule);

        return $this;

    }

}
