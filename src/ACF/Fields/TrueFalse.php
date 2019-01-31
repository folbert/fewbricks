<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\Field;
use Fewbricks\ACF\FieldInterface;

/**
 * Class TrueFalse
 * Corresponds to the true false field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. Most of the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class TrueFalse extends Field implements FieldInterface
{

    const TYPE = 'true_false';

    /**
     * @return mixed The value of the ACF setting "default_value". Returns the default ACF value 0 if none has been
     * set using Fewbricks.
     */
    public function get_default_value()
    {

        return $this->get_setting('default_value', 0);

    }

    /**
     * @return mixed The value of the ACF setting "message". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function get_message()
    {

        return $this->get_setting('message', '');

    }

    /**
     * @return mixed The value of the ACF setting "ui". Returns the default ACF value 0 if none has been
     * set using Fewbricks.
     */
    public function get_ui()
    {

        return $this->get_setting('ui', 0);

    }

    /**
     * @return mixed The value of the ACF setting "ui_off_text". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function get_ui_off_text()
    {

        return $this->get_setting('ui_off_text', '');

    }

    /**
     * @return mixed The value of the ACF setting "ui_off_text". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function get_ui_on_text()
    {

        return $this->get_setting('ui_on_text', '');

    }

    /**
     * @param string $message
     * @return $this
     */
    public function set_message($message)
    {

        return $this->set_setting('message', $message);

    }

    /**
     * @param $ui
     * @return $this
     */
    public function set_ui($ui)
    {

        return $this->set_setting('ui', $ui);

    }

    /**
     * @param $ui_off_text
     * @return $this
     */
    public function set_ui_off_text($ui_off_text)
    {

        return $this->set_setting('ui_off_text', $ui_off_text);

    }

    /**
     * @param $ui_on_text
     * @return $this
     */
    public function set_ui_on_text($ui_on_text)
    {

        return $this->set_setting('ui_on_text', $ui_on_text);

    }

}
