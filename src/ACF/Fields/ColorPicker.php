<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\Field;
use Fewbricks\ACF\FieldInterface;

/**
 * Class ColorPicker
 * Corresponds to the color picker field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. Most of the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class ColorPicker extends Field implements FieldInterface
{

    const TYPE = 'color_picker';

    /**
     * @return mixed The value of the ACF setting "default_value". Returns the default ACF value "" if none has been set
     * using Fewbricks.
     */
    public function get_default_value()
    {

        return $this->get_setting('default_value', '');

    }

    /**
     * @param mixed $default_value ACF setting. A default value used by ACF if no value has yet been saved.
     * @return $this
     */
    public function set_default_value($default_value)
    {

        return $this->set_setting('default_value', $default_value);

    }

}
