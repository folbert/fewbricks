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
    protected $arguments;

    /**
     * @var array The field groups.
     */
    private $fieldGroups;

    /**
     * EditScreen constructor.
     *
     * @param array $arguments
     */
    public function __construct($arguments = [])
    {

        $this->fieldGroups = [];

        $this->arguments = $arguments;

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
    public function getArguments()
    {

        return $this->arguments;

    }

    /**
     * @param $arguments
     */
    public function setArguments(array $arguments)
    {

        $this->arguments = $arguments;

    }

    /**
     * @param string $name
     * @param mixed  $value
     */
    public function setArgument($name, $value)
    {

        $this->arguments[$name] = $value;

    }

}
