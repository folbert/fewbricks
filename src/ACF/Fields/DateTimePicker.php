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
    public function getDisplayFormat()
    {

        return $this->getSetting('display_format', 'd/m/Y g:i a');

    }

    /**
     * @return mixed The value of the ACF setting "first_day" (Week Starts On). Returns the default ACF value "1" if none has been
     * set using Fewbricks.
     */
    public function getFirstDay()
    {

        return $this->getSetting('first_day', 1);

    }

    /**
     * @return mixed The value of the ACF setting "return_format". Returns the default ACF value "d/m/Y g:i a" if none
     * has been set using Fewbricks.
     */
    public function getReturnFormat()
    {

        return $this->getSetting('return_format', 'd/m/Y g:i a');

    }

    /**
     * ACF setting. Set the weekday that the week should start on.
     *
     * @param int $firstDay Integer representing a day. 0 = Sunday, 1 = Monday etc.
     * @return $this
     */
    public function setFirstDay($firstDay)
    {

        return $this->setSetting('first_day', $firstDay);

    }

}
