<?php

namespace Fewbricks\ACF;

use Fewbricks\Helpers\Helper;

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
    public function addFieldGroupLocationRule($rule)
    {

        if (!($rule instanceof FieldGroupLocationRule)) {
            Helper::fewbricks_die('You can only add instances of FieldGroupLocationRule to FieldGroupLocationRuleGroup');
        }

        parent::add_rule($rule);

        return $this;

    }

}
