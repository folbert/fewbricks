<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\Field;
use Fewbricks\ACF\FieldInterface;

/**
 * Class Link
 * Corresponds to the link field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. Most of the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class Link extends Field implements FieldInterface
{

    const TYPE = 'link';

    /**
     * @return mixed The value of the ACF setting "return_format". Returns the default ACF value "array" if none has
     * been set using Fewbricks.
     */
    public function get_return_format()
    {

        return $this->get_setting('return_format', 'array');

    }

    /**
     * ACF setting.
     *
     * @param string $return_format "array" or "url"
     * @return $this
     */
    public function set_return_format($return_format)
    {

        return $this->set_setting('return_format', $return_format);

    }

}
