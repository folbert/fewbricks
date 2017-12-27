<?php

namespace Fewbricks;

/**
 * Class KeyInUseException
 *
 * @package Fewbricks
 */
class KeyInUseException extends Exception
{

    /**
     * KeyInUseException constructor.
     *
     * @param                $message
     * @param int            $code
     * @param Exception|null $previous
     */
    public function __construct($message, $code = 0, Exception $previous = null)
    {

        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);

    }

    /**
     *
     */
    public function wpDie()
    {

        wp_die('<b>' . __('A message from Fewbricks', 'fewbricks') . '</b><br><br>' . $this->getMessage(),
            $this->getTitle
            ());

    }

}


