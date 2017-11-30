<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\FieldWithChoices;

/**
 * Class ButtonGroup
 * Corresponds to the button group field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. All the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class ButtonGroup extends FieldWithChoices
{

    protected $type = 'button_group';

    /**
     * ACF setting.
     *
     * @param string $layout horizontal or vertical
     *
     * @return $this
     */
    public function setLayout($layout)
    {

        return $this->setSetting('layout', $layout);

    }

}
