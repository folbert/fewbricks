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
     * @return mixed The value of the ACF setting "". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function getEndpoint()
    {

        return $this->getSetting('endpoint', false);

    }

    /**
     * @return mixed The value of the ACF setting "". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function getPlacement()
    {

        return $this->getSetting('placement', 'top');

    }

    /**
     * @return string The ACF type that ultimately decides what kind of field instances of this class is.
     */
    public function getType()
    {

        return 'tab';

    }

    /**
     * ACF setting. Set if this field should be used as an end-point and start a new group of tabs
     *
     * @param boolean $endPoint
     *
     * @return $this
     */
    public function setEndpoint($endPoint)
    {

        $this->setSetting('endpoint', $endPoint);

        return $this;

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

        $this->setSetting('placement', $placement);

        return $this;

    }

}
