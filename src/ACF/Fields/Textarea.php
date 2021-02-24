<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\Field;
use Fewbricks\ACF\FieldInterface;

/**
 * Class Textarea
 * Corresponds to the textarea field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. Most of the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class Textarea extends Field implements FieldInterface
{

    const TYPE = 'textarea';

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
     * @return mixed The value of the ACF setting "new_lines". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function get_new_lines()
    {

        return $this->get_setting('new_lines', '');

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
     * @return mixed The value of the ACF setting "rows". Returns the default ACF value 8 if none has been
     * set using Fewbricks.
     */
    public function get_rows()
    {

        return $this->get_setting('rows', '');

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
     * @param int $maxlength [sic]
     * @return $this
     */
    public function set_maxlength($maxlength)
    {

        return $this->set_setting('maxlength', $maxlength);

    }

    /**
     * ACF setting. Controls how new lines are rendered.
     *
     * @param string $new_lines "wpautop", "br" or ""
     * @return $this
     */
    public function set_new_lines($new_lines)
    {

        return $this->set_setting('new_lines', $new_lines);

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
     * ACF setting.
     *
     * @param int $rows
     * @return $this
     */
    public function set_rows($rows)
    {

        return $this->set_setting('rows', $rows);

    }

}
