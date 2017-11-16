<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\Field;

/**
 * Class Textarea
 *
 * @package Fewbricks\ACF\Fields
 */
class Textarea extends Field
{

    /**
     * Textarea constructor.
     *
     * @param       $label
     * @param       $name
     * @param       $key
     * @param array $settings
     * @param array $void
     */
    public function __construct(
        $label,
        $name,
        $key,
        array $settings = [],
        $void = null
    ) {

        parent::__construct('textarea', $label, $name, $key, $settings);

    }

}
