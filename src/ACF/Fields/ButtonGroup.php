<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\FieldInterface;
use Fewbricks\ACF\FieldWithChoices;

/**
 * Class ButtonGroup
 * Corresponds to the button group field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. Most of the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class ButtonGroup extends FieldWithChoices implements FieldInterface
{

    /**
     * @return mixed The value of the ACF setting "layout". Returns the default ACF value "horizontal" if none has been
     * set using Fewbricks.
     */
    public function getLayout()
    {

        $this->getSetting('layout', 'horizontal');

        return $this;

    }

    /**
     * @return string The ACF type that ultimately decides what kind of field instances of this class is.
     */
    public function getType()
    {

        return 'button_group';

    }

    /**
     * ACF setting.
     *
     * @param string $layout "horizontal" or "vertical"
     *
     * @return $this
     */
    public function setLayout($layout)
    {

        $this->setSetting('layout', $layout);

        return $this;

    }

}
