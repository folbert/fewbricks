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
    public function get_endpoint()
    {

        return $this->get_setting('endpoint', 0);

    }

    /**
     * @return mixed The value of the ACF setting "multi_expand". Returns the default ACF value 0 if none has been
     * set using Fewbricks.
     */
    public function get_multi_expand()
    {

        return $this->get_setting('multi_expand', 0);

    }

    /**
     * @return mixed The value of the ACF setting "open". Returns the default ACF value 0 if none has been
     * set using Fewbricks.
     */
    public function get_open()
    {

        return $this->get_setting('open', 0);

    }

    /**
     * ACF setting. Set if this field should be used as an end-point and start a new group of tabs
     *
     * @param boolean $endpoint
     * @return $this
     */
    public function set_endpoint($endpoint)
    {

        return $this->set_setting('endpoint', $endpoint);

    }

    /**
     * ACF setting. Pass true to allow this accordion to open without closing others.
     *
     * @param boolean $multi_expand
     * @return $this
     */
    public function set_multi_expand($multi_expand)
    {

        return $this->set_setting('multi_expand', $multi_expand);

    }

    /**
     * ACF setting. Pass true to display this accordion as open on page load.
     *
     * @param boolean $open
     * @return $this
     */
    public function setOpen($open)
    {

        return $this->set_setting('open', $open);

    }

}
