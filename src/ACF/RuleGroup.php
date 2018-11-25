<?php

namespace Fewbricks\ACF;

use Fewbricks\Helper;

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
     * @param array $rules An array of objects of the class
     */
    public function __construct($rules = [])
    {

        $this->rules = new RuleCollection();

        foreach ($rules AS $rule) {

            if ($rule instanceof Rule) {
                $this->rules->addItem($rule);
            }

        }

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
