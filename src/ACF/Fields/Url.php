<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\Field;
use Fewbricks\ACF\FieldInterface;

/**
 * Class Url
 * Corresponds to the url field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. Most of the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class Url extends Field implements FieldInterface
{

    const TYPE = 'url';

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
     * @param mixed $defaultValue ACF setting. A default value used by ACF if no value has yet been saved.
     * @return $this
     */
    public function set_default_value($defaultValue)
    {

        return $this->set_setting('default_value', $defaultValue);

    }

    /**
     * ACF setting. Text that appears within the input.
     *
     * @param string $placeholder
     * @return $this
     */
    public function set_placeholder($placeholder)
    {

        return $this->set_setting('placeholder', $placeholder);

    }

}
