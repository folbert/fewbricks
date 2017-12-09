<?php

namespace Fewbricks\ACF;

/**
 * Class Rule
 *
 * @package Fewbricks\ACF
 */
class Rule
{

    /**
     * @var
     */
    private $param;

    /**
     * @var
     */
    private $operator;

    /**
     * @var
     */
    private $value;

    /**
     * Rule constructor.
     *
     * @param $param
     * @param $operator
     * @param $value
     */
    public function __construct($param, $operator, $value)
    {

        $this->param = $param;
        $this->operator = $operator;
        $this->value = $value;

    }

    /**
     * @return array An array that ACF can work with.
     */
    public function toArray()
    {

        return ['param' => $this->param, 'operator' => $this->operator, 'value' => $this->value];

    }

}
