<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\FieldInterface;
use Fewbricks\ACF\FieldWithChoices;

/**
 * Class Select
 * Corresponds to the select field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. Most of the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class Select extends FieldWithChoices implements FieldInterface
{

    const TYPE = 'select';

    /**
     * @return mixed The value of the ACF setting "ajax". Returns the default ACF value false if none has been
     * set using Fewbricks.
     */
    public function getAjax()
    {

        return $this->getSetting('ajax', false);

    }

    /**
     * @return mixed The value of the ACF setting "multiple". Returns the default ACF value false if none has been
     * set using Fewbricks.
     */
    public function getMultiple()
    {

        return $this->getSetting('multiple', false);

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
     * ACF setting. If AJAX should be used to lazy load the choices.
     *
     * @param bool $ajax
     * @return $this
     */
    public function setAjax($ajax)
    {

        return $this->setSetting('ajax', $ajax);

    }

    /**
     * @param bool $multiple
     * @return $this
     */
    public function setMultiple($multiple)
    {

        return $this->setSetting('multiple', $multiple);

    }

    /**
     * ACF settings. Whether or not to use the stylised UI:
     *
     * @param boolean $ui
     * @return $this
     */
    public function setUi($ui)
    {

        return $this->setSetting('ui', $ui);

    }

}
