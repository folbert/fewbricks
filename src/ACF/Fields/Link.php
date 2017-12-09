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

    /**
     * ACF setting.
     *
     * @param string $returnFormat "array" or "url"
     *
     * @return $this
     */
    public function setReturnFormat($returnFormat)
    {

        $this->setSetting('return_format', $returnFormat);

        return $this;

    }

    /**
     * @return mixed The value of the ACF setting "return_format". Returns the default ACF value "array" if none has
     * been set using Fewbricks.
     */
    public function getReturnFormat()
    {

        return $this->getSetting('return_format', 'array');

    }

    /**
     * @return string The ACF type that ultimately decides what kind of field instances of this class is.
     */
    public function getType()
    {

        return 'link';

    }

}
