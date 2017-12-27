<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\Field;
use Fewbricks\ACF\FieldInterface;

/**
 * Class Password
 * Corresponds to the password field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. Most of the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class Password extends Field implements FieldInterface
{

    /**
     * @return mixed The value of the ACF setting "append". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function getAppend()
    {

        return $this->setSetting('append', '');

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

        return 'password';

    }

    /**
     * ACF setting. Set text to appear after the input.
     *
     * @param string $append Text to appear after the input.
     *
     * @return $this
     */
    public function setAppend($append)
    {

        $this->setSetting('append', $append);

        return $this;

    }

    /**
     * ACF setting. Set text to appear within the input.
     *
     * @param string $placeholder Text to appear within the input.
     *
     * @return $this
     */
    public function setPlaceholder($placeholder)
    {

        $this->setSetting('placeholder', $placeholder);

        return $this;

    }

    /**
     * ACF setting. Set text to appear before the input.
     *
     * @param string $prepend Text to appear before the input.
     *
     * @return $this
     */
    public function setPrepend($prepend)
    {

        $this->setSetting('prepend', $prepend);

        return $this;

    }

}
