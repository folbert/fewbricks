<?php

namespace Fewbricks\ACF;

/**
 * Class ItemWithLayouts
 *
 * @package Fewbricks\ACF
 */
class FieldWithLayouts extends Field
{

    /**
     * @var array
     */
    protected $layouts;

    public function __construct(
        $type,
        $label,
        $name,
        $key,
        array $settings = []
    ) {

        parent::__construct($type, $label, $name, $key, $settings);

        $this->layouts = [];

    }

}
