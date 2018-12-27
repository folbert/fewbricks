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

    const TYPE = 'flexible_content';

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
     * ACF setting. The max nr of layouts the user should be able to ise in this flexible content.
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
     * ACF setting. The min nr of layouts the user should be able to ise in this flexible content.
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
