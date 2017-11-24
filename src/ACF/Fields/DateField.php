<?php

namespace Fewbricks\ACF\Fields;

/**
 * Class DateField
 *
 * @package Fewbricks\ACF
 */
class DateField extends Field
{

    /**
     * ACF setting. The format displayed when editing a post.
     * Use formats from http://php.net/manual/en/function.date.php
     *
     * @param string $displayFormat
     *
     * @return $this
     */
    public function setDisplayFormat($displayFormat)
    {

        return $this->setSetting('display_format', $displayFormat);

    }

    /**
     * ACF setting. The format returned via template functions.
     * Use formats from http://php.net/manual/en/function.date.php
     *
     * @param string $returnFormat
     *
     * @return $this
     */
    public function setReturnFormat($returnFormat)
    {

        return $this->setSetting('return_format', $returnFormat);

    }

    /**
     * ACF setting.
     *
     * @param int $weekStartsOn Integer representing a day. 0 = Sunday, 1 = Monday etc.
     *
     * @return $this
     */
    public function setWeekStartsOn($weekStartsOn)
    {

        return $this->setSetting('week_starts_on', $weekStartsOn);

    }

}
