<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\Field;
use Fewbricks\ACF\FieldInterface;

/**
 * Class Number
 * Corresponds to the number field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. Most of the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class Number extends Field implements FieldInterface
{

    const TYPE = 'number';

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
     * @return mixed The value of the ACF setting "maximum_value". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function get_max()
    {

        return $this->get_setting('max', '');

    }

    /**
     * @return mixed The value of the ACF setting "minimum_value". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function get_min()
    {

        return $this->get_setting('min', '');

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
     * @return mixed The value of the ACF setting "step". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function get_step()
    {

        return $this->get_setting('step', '');

    }

    /**
     * ACF setting. Appears after the input.
     *
     * @param string $append
     * @return $this
     */
    public function set_append($append)
    {

        return $this->set_setting('append', $append);

    }

    /**
     * @param mixed $defaultValue ACF setting. A default value used by ACF if no value has yet been saved.
     * @return $this
     */
    public function set_default_value($defaultValue)
    {

        return $this->set_setting('default_value', $defaultValue);

    }

    /**
     * ACF setting.
     *
     * @param int $max
     * @return $this
     */
    public function set_max($max)
    {

        return $this->set_setting('max', $max);

    }

    /**
     * ACF setting.
     *
     * @param int $min
     * @return $this
     */
    public function set_min($min)
    {

        return $this->set_setting('min', $min);

    }

    /**
     * ACF setting. Set the placeholder for the field
     *
     * @param string $placeholder
     * @return $this
     */
    public function set_placeholder($placeholder)
    {

        return $this->set_setting('placeholder', $placeholder);

    }

    /**
     * ACF setting. Appears before the input.
     *
     * @param string $prepend
     * @return $this
     */
    public function set_prepend($prepend)
    {

        return $this->set_setting('prepend', $prepend);

    }

    /**
     * ACF setting.
     *
     * @param int $step
     * @return $this
     */
    public function set_step($step)
    {

        return $this->set_setting('step', $step);

    }

}
