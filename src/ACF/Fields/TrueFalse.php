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
     * @return mixed The value of the ACF setting "default_value". Returns the default ACF value false" if none has been
     * set using Fewbricks.
     */
    public function getDefaultValue()
    {

        return $this->getSetting('default_value', false);

    }

    /**
     * @return mixed The value of the ACF setting "message". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function getMessage()
    {

        return $this->getSetting('message', '');

    }

    /**
     * @return mixed The value of the ACF setting "ui". Returns the default ACF value false if none has been
     * set using Fewbricks.
     */
    public function getUi()
    {

        return $this->getSetting('ui', false);

    }

    /**
     * @return mixed The value of the ACF setting "ui_off_text". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function getUiOffText()
    {

        return $this->getSetting('ui_off_text', '');

    }

    /**
     * @return mixed The value of the ACF setting "ui_off_text". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function getUiOnText()
    {

        return $this->getSetting('ui_on_text', '');

    }

    /**
     * @param string $message
     * @return $this
     */
    public function setMessage($message)
    {

        return $this->setSetting('message', $message);

    }

    /**
     * @param $ui
     * @return $this
     */
    public function setUi($ui)
    {

        return $this->setSetting('ui', $ui);

    }

    /**
     * @param $ui_off_text
     * @return $this
     */
    public function setUiOffText($ui_off_text)
    {

        return $this->setSetting('ui_off_text', $ui_off_text);

    }

    /**
     * @param $ui_on_text
     * @return $this
     */
    public function setUiOnText($ui_on_text)
    {

        return $this->setSetting('ui_on_text', $ui_on_text);

    }

}
