<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\Field;
use Fewbricks\ACF\FieldInterface;

/**
 * Class Link
 * Corresponds to the link field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. All the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class Link extends Field implements FieldInterface
{

    /**
     * ACF setting.
     *
     * @param string $returnValue "array" or "url"
     *
     * @return $this
     */
    public function setReturnValue($returnValue)
    {

        return $this->setSetting('return_value', $returnValue);

    }

    /**
     * @return string The ACF type
     */
    public function getType()
    {

        return 'link';

    }

}
