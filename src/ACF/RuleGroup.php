<?php

namespace Fewbricks\ACF;

use Fewbricks\KeyInUseException;

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
     *
     * @return $this
     */
    public function addRule($rule)
    {

        try {

            $this->rules->addItem($rule);

        } catch (KeyInUseException $keyInUseException) {

            $keyInUseException->wpDie();

        }

        return $this;

    }

    /**
     * @return array An array that ACF can work with.
     */
    public function toArray()
    {

        return $this->rules->toArray();

    }


}
