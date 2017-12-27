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
     * @return string|void
     */
    public function getTitle()
    {

        return __('Duplicate key - Fewbricks', 'fewbricks');

    }

}
