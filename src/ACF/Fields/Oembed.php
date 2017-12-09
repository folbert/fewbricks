<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\Field;
use Fewbricks\ACF\FieldInterface;

/**
 * Class Oembed
 * Corresponds to the Oembed field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. Most of the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class Oembed extends Field implements FieldInterface
{

    /**
     * ACF setting.
     *
     * @param int $height  Width in px (without "px")
     *
     * @return $this
     */
    public function setHeight($height)
    {

        $this->setSetting('height', $height);

        return $this;

    }

    /**
     * ACF setting.
     *
     * @param int $width  Width in px (without "px")
     *
     * @return $this
     */
    public function setWidth($width)
    {

        $this->setSetting('width', $width);

        return $this;

    }

    /**
     * @return mixed The value of the ACF setting "height". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function getHeight()
    {

        return $this->getSetting('height', '');

    }

    /**
     * @return mixed The value of the ACF setting "width". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function getWidth()
    {

        return $this->getSetting('width', '');

    }

    /**
     * @return string The ACF type that ultimately decides what kind of field instances of this class is.
     */
    public function getType()
    {

        return 'oembed';

    }

}
