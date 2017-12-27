<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\FieldInterface;
use Fewbricks\ACF\FieldWithSubFields;

/**
 * Class Group
 * Corresponds to the group field type in ACF.
 *
 * @package Fewbricks\ACF\Fields
 */
class Group extends FieldWithSubFields implements FieldInterface
{

    /**
     * @return mixed The value of the ACF setting "layout". Returns the default ACF value "block" if none has been
     * set using Fewbricks.
     */
    public function getLayout()
    {

        return $this->getSetting('layout', 'block');

    }

    /**
     * @return string The ACF type that ultimately decides what kind of field instances of this class is.
     */
    public function getType()
    {

        return 'group';

    }

    /**
     * ACF setting to specify the style used to render the selected fields.
     *
     * @param string $layout "block", "table" or "row"
     *
     * @return $this
     */
    public function setLayout($layout)
    {

        $this->setSetting('layout', $layout);

        return $this;

    }

}
