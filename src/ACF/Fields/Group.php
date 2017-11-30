<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\FieldInterface;
use Fewbricks\ACF\FieldWithSubFields;

/**
 * Class Group
 * Corresponds to the group field type in ACF.
 *
 * @package Fewbricks\ACF\Fields
 */
class Group extends FieldWithSubFields implements FieldInterface
{

    /**
     * @return string The ACF type
     */
    public function getType()
    {

        return 'group';

    }

}
