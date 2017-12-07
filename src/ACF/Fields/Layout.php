<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\FieldInterface;
use Fewbricks\ACF\FieldWithSubFields;

/**
 * Class Layout
 * It extends FieldWithSubFields even though a layout technically speaking is not a field.
 * But it still has so much in common with FieldWithLayouts that it is motivated to extend it.
 *
 * @package Fewbricks\ACF
 */
class Layout extends FieldWithSubFields implements FieldInterface
{

    /**
     * ACF setting. Sets the value which is set using the select box labelled "Layput" in the GUI
     *
     * @param string $display table, block or row
     *
     * @return $this
     */
    public function setDisplay($display)
    {

        $this->setSetting('display', $display);

        return $this;

    }

    /**
     * ACF setting. The max nr of times this layout can be used in the current flexible content.
     *
     * @param int|string $max An empty string to disable this setting which is only needed if you have previously set it
     *                        to an int and wants to unset it.
     *
     * @return $this
     */
    public function setMax($max)
    {

        $this->setSetting('max', $max);

        return $this;

    }

    /**
     * ACF setting. The min nr of times this layout can be used in the current flexible content.
     *
     * @param int|string $min An empty string to disable this setting which is only needed if you have previously set it
     *                        to an int and wants to unset it.
     *
     * @return $this
     */
    public function setMin($min)
    {

        $this->setSetting('min', $min);

        return $this;

    }

    /**
     * @return string The ACF type that ultimately decides what kind of field instances of this class is.
     */
    public function getType()
    {

        return 'layout';

    }

}
