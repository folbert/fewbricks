<?php

namespace Fewbricks;

use Fewbricks\ACF\FieldGroup;

class EditScreen
{

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
     */
    public function __construct()
    {

        $this->fieldGroups = [];

        $this->build();

    }

    /**
     * @param FieldGroup  $fieldGroup
     */
    protected function addFieldGroup($fieldGroup)
    {

        $fieldGroup->setSetting('location', $this->location);
        $fieldGroup->register();

    }

}
