<?php

namespace Fewbricks\ACF;

/**
 * Class FieldGroupLocationRule
 * @package Fewbricks\ACF
 */
class FieldGroupLocationRule extends Rule {

    /**
     * FieldGroupLocationRule constructor.
     * @param $param
     * @param $operator
     * @param $value
     */
    public function __construct($param, $operator, $value)
    {
        parent::__construct($param, $operator, $value);
    }

}
