<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\Field;
use Fewbricks\ACF\FieldInterface;

/**
 * Class Tab
 * Corresponds to the button group field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. Most of the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class Tab extends Field implements FieldInterface
{

    /**
     * ACF setting. Set if this field should be used as an end-point and start a new group of tabs
     *
     * @param boolean $endPoint
     *
     * @return $this
     */
    public function setEndPoint($endPoint)
    {

        return $this->setSetting('endpoint', $endPoint);

    }

    /**
     * ACF setting.
     *
     * @param string $placement "top" or "left"
     *
     * @return $this
     */
    public function setPlacement($placement)
    {

        return $this->setSetting('placement', $placement);

    }

    /**
     * @return string The ACF type that ultimately decides what kind of field instances of this class is.
     */
    public function getType()
    {

        return 'tab';

    }

}
