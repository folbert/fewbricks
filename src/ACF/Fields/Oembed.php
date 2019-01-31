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

    const TYPE = 'oembed';

    /**
     * @return mixed The value of the ACF setting "height". Returns the default ACF value '' if none has been
     * set using Fewbricks.
     */
    public function get_height()
    {

        return $this->get_setting('height', '');

    }

    /**
     * @return mixed The value of the ACF setting "width". Returns the default ACF value '' if none has been
     * set using Fewbricks.
     */
    public function get_width()
    {

        return $this->get_setting('width', '');

    }

    /**
     * ACF setting.
     *
     * @param int $height Width in px (without "px")
     * @return $this
     */
    public function set_height($height)
    {

        return $this->set_setting('height', $height);

    }

    /**
     * ACF setting.
     *
     * @param int $width Width in px (without "px")
     * @return $this
     */
    public function set_width($width)
    {

        return $this->set_setting('width', $width);

    }

}
