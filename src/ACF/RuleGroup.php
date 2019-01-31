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
     * @return $this
     */
    protected function add_rule($rule)
    {

        $this->rules->add_item($rule);

        return $this;

    }

    /**
     * @return array An array that ACF can work with.
     */
    public function to_acf_array()
    {

        return $this->rules->to_acf_array();

    }


}
