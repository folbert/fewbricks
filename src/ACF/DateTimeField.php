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
     * @param string $display_format
     * @return $this
     */
    public function set_display_format($display_format)
    {

        return $this->set_setting('display_format', $display_format);

    }

    /**
     * ACF setting. The format returned via template functions.
     * Use formats from http://php.net/manual/en/function.date.php
     *
     * @param string $return_format
     * @return $this
     */
    public function set_return_format($return_format)
    {

        return $this->set_setting('return_format', $return_format);

    }

}
