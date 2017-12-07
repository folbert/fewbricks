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
     * @return string The ACF type that ultimately decides what kind of field instances of this class is.
     */
    public function getType()
    {

        return 'group';

    }

}
