<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\Field;

/**
 * Class Textarea
 * Corresponds to the textarea field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. All the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class Textarea extends Field
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

        parent::__construct('textarea', $label, $name, $key, $settings);

    }

    /**
     * ACF setting.
     *
     * @param int $characterLimit
     *
     * @return $this
     */
    public function setCharacterLimit($characterLimit)
    {

        return $this->setSetting('maxlength', $characterLimit);

    }

    /**
     * ACF setting. Controls how new lines are rendered.
     *
     * @param string $newLines "wpautop", "br" or ""
     *
     * @return $this
     */
    public function setNewLines($newLines)
    {

        return $this->setSetting('new_lines', $newLines);

    }

    /**
     * ACF setting.
     *
     * @param string $placeholder
     *
     * @return $this
     */
    public function setPlaceholder($placeholder)
    {

        return $this->setSetting('placeholder', $placeholder);

    }

    /**
     * ACF settin.
     *
     * @param int $rows
     *
     * @return $this
     */
    public function setRows($rows)
    {

        return $this->setSetting('rows', $rows);

    }

}
