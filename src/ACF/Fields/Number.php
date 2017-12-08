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

    /**
     * ACF setting. Appears after the input.
     *
     * @param string $append
     *
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
     *
     * @return $this
     */
    public function setMaximumValue($maximumValue)
    {

        return $this->setSetting('maximum_value', $maximumValue);

    }

    /**
     * ACF setting.
     *
     * @param int $minimumValue
     *
     * @return $this
     */
    public function setMinimumValue($minimumValue)
    {

        return $this->setSetting('minimum_value', $minimumValue);

    }

    /**
     * ACF setting. Set the placeholder for the field
     *
     * @param string $placeholder
     *
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
     *
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
     *
     * @return $this
     */
    public function setStep($step)
    {

        return $this->setSetting('step', $step);

    }

    /**
     * @return mixed
     */
    public function getAppend()
    {

        return $this->getSetting('append', '');

    }

    /**
     * @return mixed
     */
    public function getMaximumValue()
    {

        return $this->getSetting('maximum_value', '');

    }

    /**
     * @return mixed
     */
    public function getMinimumValue()
    {

        return $this->getSetting('minimum_value', '');

    }

    /**
     * @return mixed
     */
    public function getPlaceholder()
    {

        return $this->getSetting('placeholder', '');

    }

    /**
     * @return mixed
     */
    public function getPrepend()
    {

        return $this->getSetting('prepend', '');

    }

    /**
     * @return mixed
     */
    public function getStep()
    {

        return $this->getSetting('step', '');

    }

    /**
     * @return string The ACF type that ultimately decides what kind of field instances of this class is.
     */
    public function getType()
    {

        return 'number';

    }

}
