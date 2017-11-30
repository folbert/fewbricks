<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\Field;

/**
 * Class TrueFalse
 * Corresponds to the true false field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. All the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class TrueFalse extends Field
{

    /**
     * @var string The ACF field type
     */
    protected $type = 'true_false';

}
