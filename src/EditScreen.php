<?php

namespace Fewbricks;

use Fewbricks\ACF\FieldGroup;

class EditScreen
{

    protected $args;

    /**
     * @var array The field groups.
     */
    private $fieldGroups;

    /**
     * @var array ACFs location rules. Must be set in the child classes.
     */
    protected $location;

    /**
     * EditScreen constructor.
     *
     * @param array $args
     */
    public function __construct($args = [])
    {

        $this->fieldGroups = [];

        if(isset($args['location'])) {
            $this->location = $args['location'];
        }

        $this->args = $args;

        $this->build();

    }

    /**
     * @param FieldGroup  $fieldGroup
     */
    public function addFieldGroup($fieldGroup)
    {

        $fieldGroup->register();

    }

    /**
     * @param $name
     * @param $value
     */
    public function set_arg($name, $value)
    {

        $this->args[$name] = $value;

    }

    /**
     * @param $args
     */
    public function set_args($args)
    {

        $this->args = $args;

    }

    /**
     * @return array
     */
    public function get_args()
    {

        return $this->args;

    }

}
