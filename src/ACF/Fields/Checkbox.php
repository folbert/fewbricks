<?php

namespace Fewbricks\ACF\Fields;

/**
 * Class Checkbox
 * Corresponds to the checkbox group field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. All the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class Checkbox extends FieldWithChoices
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

        parent::__construct('checkbox', $label, $name, $key, $settings);

    }

    /**
     * ACF setting.
     *
     * @param boolean $allowCustom
     *
     * @return $this
     */
    public function setAllowCustom($allowCustom)
    {

        return $this->setSetting('allow_custom', $allowCustom);

    }

    /**
     * ACF setting
     *
     * @param string $layout vertical or horizontal
     *
     * @return $this
     */
    public function setLayout($layout)
    {

        return $this->setSetting('layout', $layout);

    }

    /**
     * ACF setting.
     *
     * @param boolean $saveCustom
     *
     * @return Checkbox $this
     */
    public function setSaveCustom($saveCustom)
    {

        return $this->setSetting('allow_custom', $saveCustom);

    }

    /**
     * ACF setting. Prepend an extra checkbox to toggle all choices.
     *
     * @param boolean $toggle
     *
     * @return Checkbox $this
     */
    public function setToggle($toggle)
    {

        return $this->setSetting('toggle', $toggle);

    }

}
