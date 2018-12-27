<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\Field;
use Fewbricks\ACF\FieldInterface;

/**
 * Class Accordion
 * Corresponds to the accordion field type in ACF.
 * This class is more or less completely stupid and only exists to accommodate quicker creation especially if you are
 * using a real IDE with auto completion. Most of the magic takes place in the Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class Accordion extends Field implements FieldInterface
{

    const TYPE = 'accordion';

    /**
     * @return mixed The value of the ACF setting "endpoint". Returns the default ACF value 0 if none has been
     * set using Fewbricks.
     */
    public function getEndpoint()
    {

        return $this->getSetting('endpoint', 0);

    }

    /**
     * @return mixed The value of the ACF setting "multi_expand". Returns the default ACF value 0 if none has been
     * set using Fewbricks.
     */
    public function getMultiExpand()
    {

        return $this->getSetting('multi_expand', 0);

    }

    /**
     * @return mixed The value of the ACF setting "open". Returns the default ACF value 0 if none has been
     * set using Fewbricks.
     */
    public function getOpen()
    {

        return $this->getSetting('open', 0);

    }

    /**
     * ACF setting. Set if this field should be used as an end-point and start a new group of tabs
     *
     * @param boolean $endPoint
     * @return $this
     */
    public function setEndpoint($endPoint)
    {

        return $this->setSetting('endpoint', $endPoint);

    }

    /**
     * ACF setting. Pass true to allow this accordion to open without closing others.
     *
     * @param boolean $multiExpand
     * @return $this
     */
    public function setMultiExpand($multiExpand)
    {

        return $this->setSetting('multi_expand', $multiExpand);

    }

    /**
     * ACF setting. Pass true to display this accordion as open on page load.
     *
     * @param boolean $open
     * @return $this
     */
    public function setOpen($open)
    {

        return $this->setSetting('open', $open);

    }

}
