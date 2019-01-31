<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\Field;
use Fewbricks\ACF\FieldInterface;

/**
 * Class Text
 * Corresponds to the text field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. Most of the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class Text extends Field implements FieldInterface
{

    const TYPE = 'text';

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
     * @return mixed The value of the ACF setting "maxlength". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function get_maxlength()
    {

        return $this->get_setting('maxlength', '');

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
     * @param int $maxlength [sic]
     * @return $this
     */
    public function set_maxlength($maxlength)
    {

        return $this->set_setting('maxlength', $maxlength);

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
