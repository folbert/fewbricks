<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\Field;

/**
 * Class Range
 * Corresponds to the range field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. All the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class Range extends Field
{

    /**
     * @param string $label The label of the field
     * @param string $name  The name of the field
     * @param string $key   The key of the field. Must be unique across the entire app
     * @param array  $settings Array where you can pass all the possible settings for the field.
     *                         See https://www.advancedcustomfields.com/resources/register-fields-via-php/#field-type%20settings
     * @param array  $void Exists only to match the nr of args of parent constructor
     */
    public function __construct(
        $label,
        $name,
        $key,
        $settings = [],
        $void = null
    ) {

        parent::__construct('range', $label, $name, $key, $settings);

    }

}
