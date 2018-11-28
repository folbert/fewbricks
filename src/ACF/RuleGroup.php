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
     *
     * @param array $rules An array of objects of the class Fewbricks\Rule
     */
    public function __construct(array $rules = [])
    {

        $this->rules = new RuleCollection();

        foreach ($rules AS $rule) {

            $this->addRule($rule);

        }

    }

    /**
     * @param Rule $rule
     * @return $this
     */
    public function addRule(Rule $rule)
    {

        $this->rules->addItem($rule);

        return $this;

    }

    /**
     * @return array An array that ACF can work with.
     */
    public function toAcfArray()
    {

        return $this->rules->toAcfArray();

    }


}
