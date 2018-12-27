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
     * @return $this
     */
    public function setReturnFormat($returnFormat)
    {

        return $this->setSetting('return_format', $returnFormat);

    }

}
