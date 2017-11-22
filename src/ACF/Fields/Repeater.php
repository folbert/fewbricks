<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\Field;
use Fewbricks\ACF\FieldCollection;
use Fewbricks\ACF\FieldWithSubFields;

/**
 * Class Repeater
 * Corresponds to the repeater field type in ACF.
 *
 * @package Fewbricks\ACF\Fields
 */
class Repeater extends FieldWithSubFields
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
        $settings = [],
        $void = null
    ) {

        parent::__construct('repeater', $label, $name, $key, $settings);

        $this->subFields = new FieldCollection();

    }

    /**
     * @param string $buttonLabel
     */
    public function setButtonLabel($buttonLabel)
    {

        $this->setSetting('button_label', $buttonLabel);

    }

    /**
     * Set a sub field to show when row is collapsed
     * @param string $fieldKey
     */
    public function setCollapsed($fieldKey)
    {

        // @todo Implement this and dont forget to deal with it when finalizing
        $this->setSetting('collapsed', $fieldKey);

    }

    /**
     * @param string $layout table, block or row
     */
    public function setLayout($layout)
    {

        $this->setSetting('layout', $layout);

    }

    /**
     * Set maximum nr of rows
     * @param int $max
     */
    public function setMax($max)
    {

        $this->setSetting('max', $max);

    }

    /**
     * Set minimum nr of rows
     * @param int $min
     */
    public function setMin($min)
    {

        $this->setSetting('min', $min);

    }

}
