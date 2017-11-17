<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\Field;

/**
 * Class FlexibleContent
 * Corresponds to the flexible content field type in ACF.
 *
 * @package Fewbricks\ACF\Fields
 */
class FlexibleContent extends Field
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

        parent::__construct('flexible_content', $label, $name, $key, $settings);

    }

}
