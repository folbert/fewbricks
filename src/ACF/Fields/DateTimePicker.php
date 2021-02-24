<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\DateTimeField;
use Fewbricks\ACF\FieldInterface;

/**
 * Class DateTimePicker
 * Corresponds to the date time picker field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. Most of the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class DateTimePicker extends DateTimeField implements FieldInterface
{

    const TYPE = 'date_time_picker';

    /**
     * @return mixed The value of the ACF setting "display_format". Returns the default ACF value "d/m/Y g:i a" if none
     * has been set using Fewbricks.
     */
    public function get_display_format()
    {

        return $this->get_setting('display_format', 'd/m/Y g:i a');

    }

    /**
     * @return mixed The value of the ACF setting "first_day" (Week Starts On). Returns the default ACF value "1" if none has been
     * set using Fewbricks.
     */
    public function get_first_day()
    {

        return $this->get_setting('first_day', 1);

    }

    /**
     * @return mixed The value of the ACF setting "return_format". Returns the default ACF value "d/m/Y g:i a" if none
     * has been set using Fewbricks.
     */
    public function get_return_format()
    {

        return $this->get_setting('return_format', 'd/m/Y g:i a');

    }

    /**
     * ACF setting. Set the weekday that the week should start on.
     *
     * @param int $first_day Integer representing a day. 0 = Sunday, 1 = Monday etc.
     * @return $this
     */
    public function set_first_day($first_day)
    {

        return $this->set_setting('first_day', $first_day);

    }

}
