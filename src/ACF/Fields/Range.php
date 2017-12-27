<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\Field;
use Fewbricks\ACF\FieldInterface;

/**
 * Class Range
 * Corresponds to the range field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. Most of the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class Range extends Field implements FieldInterface
{

    /**
     * @return mixed The value of the ACF setting "append". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function getAppend()
    {

        return $this->getSetting('append', '');

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

        return $this->setSetting('min', '');

    }

    /**
     * @return mixed The value of the ACF setting "prepend". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function getPrepend()
    {

        return $this->setSetting('prepend', '');

    }

    /**
     * @return mixed The value of the ACF setting "step". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function getStep()
    {

        return $this->setSetting('step', '');

    }

    /**
     * @return string The ACF type that ultimately decides what kind of field instances of this class is.
     */
    public function getType()
    {

        return 'range';

    }

    /**
     * ACF setting.
     *
     * @param string $append
     *
     * @return $this
     */
    public function setAppend($append)
    {

        $this->setSetting('append', $append);

        return $this;

    }

    /**
     * ACF setting.
     *
     * @param int $max
     *
     * @return $this
     */
    public function setMax($max)
    {

        $this->setSetting('max', $max);

        return $this;

    }

    /**
     * ACF setting.
     *
     * @param int $min
     *
     * @return $this
     */
    public function setMin($min)
    {

        $this->setSetting('min', $min);

        return $this;

    }

    /**
     * ACF setting.
     *
     * @param string $prepend
     *
     * @return $this
     */
    public function setPrepend($prepend)
    {

        $this->setSetting('prepend', $prepend);

        return $this;

    }

    /**
     * ACF setting.
     *
     * @param int $step
     *
     * @return $this
     */
    public function setStep($step)
    {

        $this->setSetting('step', $step);

        return $this;

    }

}
