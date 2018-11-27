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
    public function __construct($param, $operator, $value = null)
    {

        $this->param    = $param;
        $this->operator = $operator;
        $this->value    = $value;

    }

    /**
     * @return mixed
     */
    public function getOperator()
    {

        return $this->operator;

    }

    /**
     * @param $operator
     */
    public function setOperator($operator)
    {

        $this->operator = $operator;

    }

    /**
     * @return mixed
     */
    public function getParam()
    {

        return $this->param;

    }

    /**
     * @param $param
     */
    public function setParam($param)
    {

        $this->param = $param;

    }

    /**
     * @return mixed
     */
    public function getValue()
    {

        return $this->value;

    }

    /**
     * @param $value
     */
    public function setValue($value)
    {

        $this->value = $value;

    }

    /**
     * @return array An array that ACF can work with.
     */
    public function toAcfArray()
    {

        return ['param' => $this->param, 'operator' => $this->operator, 'value' => $this->value];

    }

}
