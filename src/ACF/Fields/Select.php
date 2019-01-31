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
     * @return mixed The value of the ACF setting "ajax". Returns the default ACF value 0 if none has been
     * set using Fewbricks.
     */
    public function get_ajax()
    {

        return $this->get_setting('ajax', 0);

    }

    /**
     * @return mixed The value of the ACF setting "allow_null". Returns the default ACF value 0 if none has been
     * set using Fewbricks.
     */
    public function get_allow_null()
    {

        return $this->get_setting('allow_null', 0);

    }

    /**
     * @return mixed The value of the ACF setting "multiple". Returns the default ACF value 0 if none has been
     * set using Fewbricks.
     */
    public function get_multiple()
    {

        return $this->get_setting('multiple', 0);

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
     * ACF setting. If AJAX should be used to lazy load the choices.
     *
     * @param bool $ajax
     * @return $this
     */
    public function set_ajax($ajax)
    {

        return $this->set_setting('ajax', $ajax);

    }

    /**
     * ACF setting.
     *
     * @param bool $allowNull
     * @return $this
     */
    public function set_allow_null($allowNull)
    {

        return $this->set_setting('allow_null', $allowNull);


    }

    /**
     * @param bool $multiple
     * @return $this
     */
    public function set_multiple($multiple)
    {

        return $this->set_setting('multiple', $multiple);

    }

    /**
     * ACF settings. Whether or not to use the stylised UI:
     *
     * @param boolean $ui
     * @return $this
     */
    public function set_ui($ui)
    {

        return $this->set_setting('ui', $ui);

    }

}
