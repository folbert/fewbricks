<?php

namespace Fewbricks\ACF;

/**
 * Interface FieldInterface
 *
 * @package Fewbricks\ACF
 */
interface FieldInterface
{

    /*
     * @return string The name of the field type that ACF uses.
     */
    public function get_type();

}
