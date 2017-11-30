<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\Field;
use Fewbricks\ACF\FieldInterface;

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
class Textarea extends Field implements FieldInterface
{

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

    /**
     * @return string The ACF type
     */
    public function getType()
    {

        return 'textarea';

    }

}
