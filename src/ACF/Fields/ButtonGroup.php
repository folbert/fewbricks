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
    public function get_allow_null()
    {

        return $this->get_setting('allow_null', 0);

    }

    /**
     * @return mixed The value of the ACF setting "layout". Returns the default ACF value "horizontal" if none has been
     * set using Fewbricks.
     */
    public function get_layout()
    {

        return $this->get_setting('layout', 'horizontal');

    }

    /**
     * ACF setting.
     *
     * @param bool $allow_null
     * @return $this
     */
    public function set_allow_null($allow_null)
    {

        return $this->set_setting('allow_null', $allow_null);


    }

    /**
     * ACF setting.
     *
     * @param string $layout "horizontal" or "vertical"
     * @return $this
     */
    public function set_layout($layout)
    {

        return $this->set_setting('layout', $layout);

    }

}
