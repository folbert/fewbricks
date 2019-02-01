<?php

namespace Fewbricks\ACF;

/**
 * Class FieldWithChoices
 *
 * @package Fewbricks\ACF
 */
class FieldWithChoices extends Field
{

    /**
     * @return mixed The value of the ACF setting "choices". Returns the default ACF value of an empty array if none has
     * been set using Fewbricks.
     */
    public function getChoices()
    {

        return $this->get_setting('choices', []);

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
     * @return mixed The value of the ACF setting "return_format". Returns the default ACF value "value" if none has
     * been set using Fewbricks.
     */
    public function get_return_format()
    {

        return $this->get_setting('return_format', 'value');

    }

    /**
     * ACF setting.
     *
     * @param array $choices Associative array with options. Key will be name and value will be value.
     * @return $this
     */
    public function set_choices($choices)
    {

        return $this->set_setting('choices', $choices);

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
     * ACF setting. Specify the returned value on front end.
     *
     * @param $return_format "value", "label" or "array" (for both)
     * @return $this
     */
    public function set_return_format($return_format)
    {

        return $this->set_setting('return_format', $return_format);

    }

}
