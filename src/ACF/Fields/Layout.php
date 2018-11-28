<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\FieldInterface;
use Fewbricks\ACF\FieldWithFields;

/**
 * Class Layout
 * It extends FieldWithSubFields even though a layout technically speaking is not a field.
 * But it still has so much in common with FieldWithLayouts that it is motivated to extend it.
 *
 * @package Fewbricks\ACF
 */
class Layout extends FieldWithFields implements FieldInterface
{

    const MY_TYPE = 'layout';

    /**
     * @return mixed The value of the ACF setting "display". Returns the default ACF value "block" if none has been
     * set using Fewbricks.
     */
    public function getDisplay()
    {

        return $this->getSetting('display', 'block');

    }

    /**
     * @return mixed The value of the ACF setting "max". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function getMax()
    {

        return $this->getSetting('max', '');

    }

    /**
     * @return mixed The value of the ACF setting "min". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function getMin()
    {

        return $this->getSetting('min', '');

    }

    /**
     * ACF setting. Sets the value which is set using the select box labelled "Layout" in the GUI
     *
     * @param string $display table, block or row
     * @return $this
     */
    public function setDisplay($display)
    {

        return $this->setSetting('display', $display);

    }

    /**
     * ACF setting. The max nr of times this layout can be used in the current flexible content.
     *
     * @param int|string $max An empty string to disable this setting which is only needed if you have previously set it
     *                        to an int and wants to unset it.
     * @return $this
     */
    public function setMax($max)
    {

        return $this->setSetting('max', $max);

    }

    /**
     * ACF setting. The min nr of times this layout can be used in the current flexible content.
     *
     * @param int|string $min An empty string to disable this setting which is only needed if you have previously set it
     *                        to an int and wants to unset it.
     * @return $this
     */
    public function setMin($min)
    {

        return $this->setSetting('min', $min);

    }

}
