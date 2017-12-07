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
     * ACF setting.
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

        return $this->setSetting('max', $maximumValue);

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

        return $this->setSetting('min', $minimumValue);

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

        return $this->setSetting('prepend', $prepend);

    }

    /**
     * ACF setting.
     *
     * @param int $stepSize
     *
     * @return $this
     */
    public function setStepSize($stepSize)
    {

        return $this->setSetting('step', $stepSize);

    }

    /**
     * @return string The ACF type that ultimately decides what kind of field instances of this class is.
     */
    public function getType()
    {

        return 'range';

    }


}
