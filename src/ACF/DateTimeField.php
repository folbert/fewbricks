<?php

namespace Fewbricks\ACF;

/**
 * Class DateField
 *
 * @package Fewbricks\ACF
 */
class DateTimeField extends Field
{

    /**
     * @return mixed The value of the ACF setting "first_day" (Week Starts On). Returns the default ACF value "1" if none has been
     * set using Fewbricks.
     */
    public function getFirstDay()
    {

        return $this->getSetting('first_day', 1);

    }

    /**
     * ACF setting. The format displayed when editing a post.
     * Use formats from http://php.net/manual/en/function.date.php
     *
     * @param string $displayFormat
     * @return $this
     */
    public function setDisplayFormat($displayFormat)
    {

        return $this->setSetting('display_format', $displayFormat);

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

    /**
     * ACF setting. The format returned via template functions.
     * Use formats from http://php.net/manual/en/function.date.php
     *
     * @param string $returnFormat
     * @return $this
     */
    public function setReturnFormat($returnFormat)
    {

        return $this->setSetting('return_format', $returnFormat);

    }

}
