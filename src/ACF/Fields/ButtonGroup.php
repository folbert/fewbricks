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

    const TYPE = 'button_group';

    /**
     * @return mixed The value of the ACF setting "allow_null". Returns the default ACF value 0 if none has been
     * set using Fewbricks.
     */
    public function getAllowNull()
    {

        return $this->getSetting('allow_null', 0);

    }

    /**
     * @return mixed The value of the ACF setting "layout". Returns the default ACF value "horizontal" if none has been
     * set using Fewbricks.
     */
    public function getLayout()
    {

        return $this->getSetting('layout', 'horizontal');

    }

    /**
     * ACF setting.
     *
     * @param bool $allowNull
     * @return $this
     */
    public function setAllowNull($allowNull)
    {

        return $this->setSetting('allow_null', $allowNull);


    }

    /**
     * ACF setting.
     *
     * @param string $layout "horizontal" or "vertical"
     * @return $this
     */
    public function setLayout($layout)
    {

        return $this->setSetting('layout', $layout);

    }

}
