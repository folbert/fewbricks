<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\FieldInterface;
use Fewbricks\ACF\FieldWithLayouts;

/**
 * Class FlexibleContent
 * Corresponds to the flexible content field type in ACF.
 *
 * @package Fewbricks\ACF\Fields
 */
class FlexibleContent extends FieldWithLayouts implements FieldInterface
{

    /**
     * ACF setting. The max nr of layouts the user should be able to ise in this flexible content.
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
     * ACF setting. The min nr of layouts the user should be able to ise in this flexible content.
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
     * @return mixed The value of the ACF setting "max". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function getMax()
    {

        return $this->getSetting('max', 0);

    }

    /**
     * @return mixed The value of the ACF setting "min". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function getMin()
    {

        return $this->getSetting('min', 0);

    }

    /**
     * @return string The ACF type that ultimately decides what kind of field instances of this class is.
     */
    public function getType()
    {

        return 'flexible_content';

    }


}
