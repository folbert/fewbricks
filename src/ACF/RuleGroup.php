<?php

namespace Fewbricks\ACF;

/**
 * Class RuleGroup
 *
 * The relation between each rule in a rule group is "and".
 *
 * @package Fewbricks\ACF
 */
class RuleGroup
{

    /**
     * @var RuleCollection
     */
    private $rules;

    /**
     * RuleGroup constructor.
     */
    public function __construct()
    {

        $this->rules = new RuleCollection();

    }

    /**
     * @param Rule $rule
     */
    public function addRule(Rule $rule)
    {

        $this->rules->addItem($rule);

    }

    /**
     * @return array An array that ACF can work with.
     */
    public function toAcfArray()
    {

        return $this->rules->toAcfArray();

    }


}
