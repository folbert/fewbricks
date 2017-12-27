<?php

namespace Fewbricks;

use Fewbricks\ACF\FieldGroup;

/**
 * Class EditScreen
 *
 * @package Fewbricks
 */
class FieldGroupsCollection
{

    /**
     * @var array
     */
    protected $args;

    /**
     * @var array The field groups.
     */
    private $fieldGroups;

    /**
     * EditScreen constructor.
     *
     * @param array $args
     */
    public function __construct($args = [])
    {

        $this->fieldGroups = [];

        $this->args = $args;

        $this->build();

    }

    /**
     * @param FieldGroup $fieldGroup
     */
    public function addFieldGroup($fieldGroup)
    {

        $fieldGroup->register();

    }

    /**
     * @return array
     */
    public function get_args()
    {

        return $this->args;

    }

    /**
     * @param $args
     */
    public function set_args($args)
    {

        $this->args = $args;

    }

    /**
     * @param $name
     * @param $value
     */
    public function set_arg($name, $value)
    {

        $this->args[$name] = $value;

    }

}
