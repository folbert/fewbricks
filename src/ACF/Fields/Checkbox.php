<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\FieldWithChoices;

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

    protected $type = 'checkbox';

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
