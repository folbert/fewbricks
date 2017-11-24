<?php

namespace Fewbricks\ACF\Fields;

/**
 * Class FlexibleContent
 * Corresponds to the flexible content field type in ACF.
 *
 * @package Fewbricks\ACF\Fields
 */
class FlexibleContent extends FieldWithLayouts
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

        parent::__construct('flexible_content', $label, $name, $key, $settings);

    }

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

        return $this->setSetting('max', $max);

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

        return $this->setSetting('min', $min);

    }


}
