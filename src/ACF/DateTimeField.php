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

    /**
     * ACF setting. The format displayed when editing a post.
     *
     * @param mixed $defaultValue
     *
     * @return mixed
     */
    public function getDisplayFormat($defaultValue = false)
    {

        return $this->getSetting('display_format', $defaultValue);

    }

    /**
     * ACF setting. The format returned via template functions.
     *
     * @param mixed $defaultValue
     *
     * @return mixed
     */
    public function getReturnFormat($defaultValue)
    {

        return $this->getSetting('return_format', $defaultValue);

    }

    /**
     * ACF setting.
     *
     * @param mixed $defaultValue
     *
     * @return mixed
     */
    public function getWeekStartsOn($defaultValue)
    {

        return $this->getSetting('week_starts_on', $defaultValue);

    }

}
