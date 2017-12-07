<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\DateTimeField;
use Fewbricks\ACF\FieldInterface;

/**
 * Class DatePicker
 * Corresponds to the date picker field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. Most of the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class DatePicker extends DateTimeField implements FieldInterface
{

    /**
     * @return string The ACF type that ultimately decides what kind of field instances of this class is.
     */
    public function getType()
    {

        return 'date_picker';

    }

}
