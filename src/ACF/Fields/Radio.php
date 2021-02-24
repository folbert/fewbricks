<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\FieldInterface;
use Fewbricks\ACF\FieldWithChoices;

/**
 * Class Radio
 * Corresponds to the radio field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. Most of the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class Radio extends FieldWithChoices implements FieldInterface
{

    const TYPE = 'radio';

    /**
     * @return mixed The value of the ACF setting "allow_null". Returns the default ACF value false if none has been
     * set using Fewbricks.
     */
    public function get_allow_null()
    {

        return $this->get_setting('allow_null', 0);

    }

    /**
     * @return mixed The value of the ACF setting "layout". Returns the default ACF value "vertical" if none has been
     * set using Fewbricks.
     */
    public function get_layout()
    {

        return $this->get_setting('layout', 'vertical');

    }

    /**
     * @return mixed The value of the ACF setting "other_choice". Returns the default ACF value false if none has been
     * set using Fewbricks.
     */
    public function get_other_choice()
    {

        return $this->get_setting('other_choice', 0);

    }

    /**
     * @return mixed The value of the ACF setting "save_other_choice". Returns the default ACF value false if none has
     * been set using Fewbricks.
     */
    public function get_save_other_choice()
    {

        return $this->get_setting('save_other_choice', 0);

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
     * @param string $layout "vertical" or "horizontal".
     * @return $this
     */
    public function set_layout($layout)
    {

        return $this->set_setting('layout', $layout);

    }

    /**
     * ACF setting.
     *
     * @param mixed $other_choice
     * @return $this
     */
    public function set_other_choice($other_choice)
    {

        return $this->set_setting('other_choice', $other_choice);

    }

    /**
     * ACF setting.
     *
     * @param mixed $save_other_choice
     * @return $this
     */
    public function set_save_other_choice($save_other_choice)
    {

        return $this->set_setting('save_other_choice', $save_other_choice);

    }

}
