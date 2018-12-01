<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\Field;
use Fewbricks\ACF\FieldInterface;

/**
 * Class Number
 * Corresponds to the number field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. Most of the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class Number extends Field implements FieldInterface
{

    const TYPE = 'number';

    /**
     * @return mixed The value of the ACF setting "append". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function getAppend()
    {

        return $this->getSetting('append', '');

    }

    /**
     * @return mixed The value of the ACF setting "maximum_value". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function getMaximumValue()
    {

        return $this->getSetting('maximum_value', '');

    }

    /**
     * @return mixed The value of the ACF setting "minimum_value". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function getMinimumValue()
    {

        return $this->getSetting('minimum_value', '');

    }

    /**
     * @return mixed The value of the ACF setting "placeholder". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function getPlaceholder()
    {

        return $this->getSetting('placeholder', '');

    }

    /**
     * @return mixed The value of the ACF setting "prepend". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function getPrepend()
    {

        return $this->getSetting('prepend', '');

    }

    /**
     * @return mixed The value of the ACF setting "step". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function getStep()
    {

        return $this->getSetting('step', '');

    }

    /**
     * ACF setting. Appears after the input.
     *
     * @param string $append
     * @return $this
     */
    public function setAppend($append)
    {

        return $this->setSetting('append', $append);

    }

    /**
     * ACF setting.
     *
     * @param int $maximumValue
     * @return $this
     */
    public function setMaximumValue($maximumValue)
    {

        return $this->setSetting('max', $maximumValue);

    }

    /**
     * ACF setting.
     *
     * @param int $minimumValue
     * @return $this
     */
    public function setMinimumValue($minimumValue)
    {

        return $this->setSetting('min', $minimumValue);

    }

    /**
     * ACF setting. Set the placeholder for the field
     *
     * @param string $placeholder
     * @return $this
     */
    public function setPlaceholder($placeholder)
    {

        return $this->setSetting('placeholder', $placeholder);

    }

    /**
     * ACF setting. Appears before the input.
     *
     * @param string $prepend
     * @return $this
     */
    public function setPrepend($prepend)
    {

        return $this->setSetting('prepend', $prepend);

    }

    /**
     * ACF setting.
     *
     * @param int $step
     * @return $this
     */
    public function setStep($step)
    {

        return $this->setSetting('step', $step);

    }

}
