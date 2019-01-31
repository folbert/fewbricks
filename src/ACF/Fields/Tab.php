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

    const TYPE = 'tab';

    /**
     * @return mixed The value of the ACF setting "endpoint". Returns the default ACF value 0 if none has been
     * set using Fewbricks.
     */
    public function get_endpoint()
    {

        return $this->get_setting('endpoint', 0);

    }

    /**
     * @return mixed The value of the ACF setting "placement". Returns the default ACF value "top" if none has been
     * set using Fewbricks.
     */
    public function get_placement()
    {

        return $this->get_setting('placement', 'top');

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
     * ACF setting.
     *
     * @param string $placement "top" or "left"
     * @return $this
     */
    public function set_placement($placement)
    {

        return $this->set_setting('placement', $placement);

    }

}
