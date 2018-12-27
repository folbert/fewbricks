<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\FieldInterface;
use Fewbricks\ACF\FieldWithChoices;

/**
 * Class Radio
 * Corresponds to the radio field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. Most of the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class Radio extends FieldWithChoices implements FieldInterface
{

    const TYPE = 'radio';

    /**
     * @return mixed The value of the ACF setting "allow_null". Returns the default ACF value false if none has been
     * set using Fewbricks.
     */
    public function getAllowNull()
    {

        return $this->getSetting('allow_null', 0);

    }

    /**
     * @return mixed The value of the ACF setting "layout". Returns the default ACF value "vertical" if none has been
     * set using Fewbricks.
     */
    public function getLayout()
    {

        return $this->getSetting('layout', 'vertical');

    }

    /**
     * @return mixed The value of the ACF setting "other_choice". Returns the default ACF value false if none has been
     * set using Fewbricks.
     */
    public function getOtherChoice()
    {

        return $this->getSetting('other_choice', 0);

    }

    /**
     * @return mixed The value of the ACF setting "save_other_choice". Returns the default ACF value false if none has
     * been set using Fewbricks.
     */
    public function getSaveOtherChoice()
    {

        return $this->getSetting('save_other_choice', 0);

    }

    /**
     * ACF setting.
     *
     * @param bool $allowNull
     * @return $this
     */
    public function setAllowNull($allowNull)
    {

        return $this->setSetting('allow_null', $allowNull);


    }

    /**
     * ACF setting.
     *
     * @param string $layout "vertical" or "horizontal".
     * @return $this
     */
    public function setLayout($layout)
    {

        return $this->setSetting('layout', $layout);

    }

    /**
     * ACF setting.
     *
     * @param mixed $otherChoice
     * @return $this
     */
    public function setOtherChoice($otherChoice)
    {

        return $this->setSetting('other_choice', $otherChoice);

    }

    /**
     * ACF setting.
     *
     * @param mixed $saveOtherChoice
     * @return $this
     */
    public function setSaveOtherChoice($saveOtherChoice)
    {

        return $this->setSetting('save_other_choice', $saveOtherChoice);

    }

}
