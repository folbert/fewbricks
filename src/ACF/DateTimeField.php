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
    public function set_display_format($displayFormat)
    {

        return $this->set_setting('display_format', $displayFormat);

    }

    /**
     * ACF setting. The format returned via template functions.
     * Use formats from http://php.net/manual/en/function.date.php
     *
     * @param string $returnFormat
     * @return $this
     */
    public function set_return_format($returnFormat)
    {

        return $this->set_setting('return_format', $returnFormat);

    }

}
