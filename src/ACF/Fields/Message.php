<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\Field;

/**
 * Class Message
 * Corresponds to the message field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. All the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class Message extends Field
{

    /**
     * @var string The ACF field type
     */
    protected $type = 'message';

    /**
     * ACF setting. Allow HTML markup to display as visible text instead of rendering.
     *
     * @param boolean $escapeHtml
     *
     * @return $this
     */
    public function setEscapeHtml($escapeHtml)
    {

        return $this->setSetting('esc_html', $escapeHtml);

    }

    /**
     * ACF setting. Controls how new lines are rendered.
     *
     * @param string $newLines "wpautop" (automaticaly add paragraphs), "br" (automatically add <br>) or "" (no
     *                         formatting)
     *
     * @return $this
     */
    public function setNewLines($newLines)
    {

        return $this->setSetting('new_lined', $newLines);

    }

}
