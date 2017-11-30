<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\DateTimeField;

/**
 * Class DatePicker
 * Corresponds to the date picker field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. All the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class DatePicker extends DateTimeField
{

    protected $type = 'date_picker';

}
