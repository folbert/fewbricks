<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\Field;

/**
 * Class Range
 * Corresponds to the range field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. All the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class Range extends Field
{

    /**
     * @param string $label    The label of the field
     * @param string $name     The name of the field
     * @param string $key      The key of the field. Must be unique across the
     *                         entire app
     * @param array  $settings Array where you can pass all the possible
     *                         settings for the field.
     *                         https://www.advancedcustomfields.com/resources/register-fields-via-php/#field-type%20settings
     * @param array  $void     Not used. Exists only to match the nr of args of parent
     *                         constructor.
     */
    public function __construct(
        $label,
        $name,
        $key,
        $settings = [],
        $void = null
    ) {

        parent::__construct('range', $label, $name, $key, $settings);

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

}
