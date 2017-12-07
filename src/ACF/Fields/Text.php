<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\Field;
use Fewbricks\ACF\FieldInterface;

/**
 * Class Text
 * Corresponds to the text field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. Most of the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class Text extends Field implements FieldInterface
{

    /**
     * ACF setting. Set text to appear after the input.
     *
     * @param string $append Text to appear after the input.
     *
     * @return $this
     */
    public function setAppend($append)
    {

        return $this->setSetting('append', $append);

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
     * ACF setting. Set text to appear before the input.
     *
     * @param string $prepend Text to appear before the input.
     *
     * @return $this
     */
    public function setPrepend($prepend)
    {

        return $this->setSetting('prepend', $prepend);

    }

    /**
     * @return string The ACF type that ultimately decides what kind of field instances of this class is.
     */
    public function getType()
    {

        return 'text';

    }

}
