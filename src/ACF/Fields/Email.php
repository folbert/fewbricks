<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\Field;
use Fewbricks\ACF\FieldInterface;

/**
 * Class Email
 * Corresponds to the button group field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. Most of the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class Email extends Field implements FieldInterface
{

    const TYPE = 'email';

    /**
     * @return mixed The value of the ACF setting "append". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function get_append()
    {

        return $this->get_setting('append', '');

    }

    /**
     * @return mixed The value of the ACF setting "default_value". Returns the default ACF value "" if none has been set
     * using Fewbricks.
     */
    public function get_default_value()
    {

        return $this->get_setting('default_value', '');

    }

    /**
     * @return mixed The value of the ACF setting "placeholder". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function get_placeholder()
    {

        return $this->get_setting('placeholder', '');

    }

    /**
     * @return mixed The value of the ACF setting "prepend". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function get_prepend()
    {

        return $this->get_setting('prepend', '');

    }

    /**
     * ACF setting. Set text to appear after the input.
     *
     * @param string $append Text to appear after the input.
     * @return $this
     */
    public function set_append($append)
    {

        return $this->set_setting('append', $append);

    }

    /**
     * @param mixed $default_value ACF setting. A default value used by ACF if no value has yet been saved.
     * @return $this
     */
    public function set_default_value($default_value)
    {

        return $this->set_setting('default_value', $default_value);

    }

    /**
     * ACF setting.
     *
     * @param string $placeholder
     * @return $this
     */
    public function set_placeholder($placeholder)
    {

        return $this->set_setting('placeholder', $placeholder);

    }

    /**
     * ACF setting. Set text to appear before the input.
     *
     * @param string $prepend Text to appear before the input.
     * @return $this
     */
    public function set_prepend($prepend)
    {

        return $this->set_setting('prepend', $prepend);

    }

}
