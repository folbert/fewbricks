<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\FieldInterface;
use Fewbricks\ACF\FieldWithChoices;

/**
 * Class Checkbox
 * Corresponds to the checkbox group field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. Most of the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class Checkbox extends FieldWithChoices implements FieldInterface
{

    const TYPE = 'checkbox';

    /**
     * @return mixed The value of the ACF setting "allow_custom". Returns the default ACF value 0 if none has been
     * set using Fewbricks.
     */
    public function get_allow_custom()
    {

        return $this->get_setting('allow_custom', 0);

    }

    /**
     * @return mixed The value of the ACF setting "allow_custom". Returns the default ACF value false if none has been
     * set using Fewbricks.
     */
    public function get_layout()
    {

        return $this->get_setting('layout', 'vertical');

    }

    /**
     * @return mixed The value of the ACF setting "save_custom". Returns the default ACF value 0 if none has been
     * set using Fewbricks.
     */
    public function get_save_custom()
    {

        return $this->get_setting('save_custom', 0);

    }

    /**
     * @return mixed The value of the ACF setting "toggle". Returns the default ACF value 0 if none has been
     * set using Fewbricks.
     */
    public function get_toggle()
    {

        return $this->get_setting('toggle', 0);

    }

    /**
     * ACF setting.
     *
     * @param boolean $allow_custom
     * @return $this
     */
    public function setAllowCustom($allow_custom)
    {

        return $this->set_setting('allow_custom', $allow_custom);

    }

    /**
     * ACF setting
     *
     * @param string $layout vertical or horizontal
     * @return $this
     */
    public function set_layout($layout)
    {

        return $this->set_setting('layout', $layout);

    }

    /**
     * ACF setting.
     *
     * @param boolean $save_custom
     * @return $this
     */
    public function set_save_custom($save_custom)
    {

        return $this->set_setting('save_custom', $save_custom);

    }

    /**
     * ACF setting. Send true to prepend an extra checkbox to toggle all choices.
     *
     * @param boolean $toggle
     * @return $this
     */
    public function set_toggle($toggle)
    {

        return $this->set_setting('toggle', $toggle);

    }

}
