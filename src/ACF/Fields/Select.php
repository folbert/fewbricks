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
     * @return string The ACF type that ultimately decides what kind of field instances of this class is.
     */
    public function getType()
    {

        return 'select';

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
     * @param boolean $ajax
     *
     * @return $this
     */
    public function setAjax($ajax)
    {

        $this->setSetting('ajax', $ajax);

        return $this;

    }

    /**
     * @param $multiple
     *
     * @return mixed
     */
    public function setMultiple($multiple)
    {

        $this->getSetting('multiple', $multiple);

        return $this;

    }

    /**
     * ACF settings. Whether or not to use the stylised UI:
     *
     * @param boolean $ui
     *
     * @return $this
     */
    public function setUi($ui)
    {

        $this->setSetting('ui', $ui);

        return $this;

    }

}
