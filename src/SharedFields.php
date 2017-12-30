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

    public function __construct(array $args = [])
    {
        parent::__construct($args);

        $this->applyFields();

    }

}
