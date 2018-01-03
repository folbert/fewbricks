<?php

namespace Fewbricks;

/**
 * Class Exception
 *
 * @package Fewbricks\Exception
 */
class Exception extends \Exception
{

    /**
     * @return string
     */
    public function getTitle()
    {

        return __('Duplicate key - Fewbricks', 'fewbricks');

    }

}
