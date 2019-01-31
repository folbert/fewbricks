<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\Field;
use Fewbricks\ACF\FieldInterface;

/**
 * Class Password
 * Corresponds to the password field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. Most of the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class Password extends Field implements FieldInterface
{

    const TYPE = 'password';

    /**
     * @return mixed The value of the ACF setting "append". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function get_append()
    {

        return $this->get_setting('append', '');

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
     * ACF setting. Set text to appear within the input.
     *
     * @param string $placeholder Text to appear within the input.
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
