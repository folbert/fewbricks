<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\Field;
use Fewbricks\ACF\FieldInterface;

/**
 * Class ColorPicker
 * Corresponds to the color picker field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. All the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class ColorPicker extends Field implements FieldInterface
{

    /**
     * @return string The ACF type
     */
    public function getType()
    {

        return 'color_picker';

    }

}
