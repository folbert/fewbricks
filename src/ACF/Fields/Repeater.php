<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\FieldCollection;
use Fewbricks\ACF\FieldInterface;
use Fewbricks\ACF\FieldWithSubFields;

/**
 * Class Repeater
 * Corresponds to the repeater field type in ACF.
 *
 * @package Fewbricks\ACF\Fields
 */
class Repeater extends FieldWithSubFields implements FieldInterface
{

    /**
     * @param string $label    The label of the field
     * @param string $name     The name of the field
     * @param string $key      The key of the field. Must be unique across the
     *                         entire app
     * @param array  $settings Array where you can pass all the possible
     *                         settings for the field.
     *                         https://www.advancedcustomfields.com/resources/register-fields-via-php/#field-type%20settings
     * @param array  $void     Not used. Exists only to match the nr of args of parent
     *                         constructor.
     */
    public function __construct(
        $label,
        $name,
        $key,
        $settings = []
    ) {

        parent::__construct($label, $name, $key, $settings);

        $this->subFields = new FieldCollection();

    }

    /**
     * @param string $buttonLabel
     *
     * @return $this
     */
    public function setButtonLabel($buttonLabel)
    {

        $this->setSetting('button_label', $buttonLabel);

        return $this;

    }

    /**
     * Set a sub field to show when row is collapsed
     *
     * @param string $fieldKey
     *
     * @return $this
     */
    public function setCollapsed($fieldKey)
    {

        // @todo Implement this and dont forget to deal with it when finalizing
        $this->setSetting('collapsed', $fieldKey);

        return $this;

    }

    /**
     * @param string $layout table, block or row
     *
     * @return $this
     */
    public function setLayout($layout)
    {

        $this->setSetting('layout', $layout);

        return $this;

    }

    /**
     * Set maximum nr of rows
     *
     * @param int $max
     *
     * @return $this
     */
    public function setMax($max)
    {

        $this->setSetting('max', $max);

        return $this;

    }

    /**
     * Set minimum nr of rows
     *
     * @param int $min
     *
     * @return $this
     */
    public function setMin($min)
    {

        $this->setSetting('min', $min);

        return $this;

    }

    /**
     * @return string The ACF type that ultimately decides what kind of field instances of this class is.
     */
    public function getType()
    {

        return 'repeater';

    }

}
