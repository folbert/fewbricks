<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\Field;
use Fewbricks\ACF\FieldInterface;

/**
 * Class Text
 * Corresponds to the text field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. Most of the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class Text extends Field implements FieldInterface
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
     * @return mixed The value of the ACF setting "maxlength". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function getMaxlength()
    {

        return $this->getSetting('maxlength', '');

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
     * @return string The ACF type that ultimately decides what kind of field instances of this class is.
     */
    public function getType()
    {

        return 'text';

    }

    /**
     * ACF setting. Set text to appear after the input.
     *
     * @param string $append Text to appear after the input.
     */
    public function setAppend($append)
    {

        $this->setSetting('append', $append);

    }

    /**
     * ACF setting.
     *
     * @param int $maxlength [sic]
     */
    public function setMaxlength($maxlength)
    {

        $this->setSetting('maxlength', $maxlength);

    }

    /**
     * ACF setting.
     *
     * @param string $placeholder
     */
    public function setPlaceholder($placeholder)
    {

        $this->setSetting('placeholder', $placeholder);

    }

    /**
     * ACF setting. Set text to appear before the input.
     *
     * @param string $prepend Text to appear before the input.
     */
    public function setPrepend($prepend)
    {

        $this->setSetting('prepend', $prepend);

    }

}
