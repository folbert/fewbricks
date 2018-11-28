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
     * @var string
     */
    private $param;

    /**
     * @var string
     */
    private $operator;

    /**
     * @var string
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

        $this->param = $param;
        $this->operator = $operator;
        $this->value = $value;

    }

    /**
     * @return mixed
     * @return $this
     */
    public function getOperator()
    {

        return $this->operator;

    }

    /**
     * @param $operator
     * @return $this
     */
    public function setOperator(string $operator)
    {

        $this->operator = $operator;

        return $this;

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
     * @return $this
     */
    public function setParam($param)
    {

        $this->param = $param;

        return $this;

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
     * @return $this
     */
    public function setValue($value)
    {

        $this->value = $value;

        return $this;

    }

    /**
     * @return array An array that ACF can work with.
     */
    public function toAcfArray()
    {

        return ['param' => $this->param, 'operator' => $this->operator, 'value' => $this->value];

    }

}
