<?php

namespace Fewbricks;

use Fewbricks\ACF\FieldCollection;

/**
 * Class SharedFields
 *
 * @package Fewbricks
 */
class SharedFields extends FieldCollection
{

    /**
     * @var string
     */
    private $baseKey;

    /**
     * SharedFields constructor.
     *
     * @param string $baseKey The key that the field instance will get prepended to their keys.
     * @param array  $args    Array with any args that you want to pass and use in your child classes.
     */
    public function __construct($baseKey, $args = [])
    {

        $this->baseKey = $baseKey;

        parent::__construct($args);

    }

    /**
     * @param null $void
     *
     * @return array
     */
    public function toAcfArray($void = null)
    {
        return parent::toAcfArray($this->baseKey);
    }

}
