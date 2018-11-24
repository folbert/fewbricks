<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\Field;
use Fewbricks\ACF\FieldInterface;

/**
 * Class Message
 * Corresponds to the message field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. Most of the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class Message extends Field implements FieldInterface
{

    /**
     * @return mixed The value of the ACF setting "esc_html". Returns the default ACF value "false" if none has been
     * set using Fewbricks.
     */
    public function getEscHtml()
    {

        return $this->getSetting('esc_html', 0);

    }

    /**
     * @return mixed The value of the ACF setting "message". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function getMessage()
    {

        return $this->getSetting('message', '');

    }

    /**
     * @return mixed The value of the ACF setting "new_lines". Returns the default ACF value "wpautop" if none has been
     * set using Fewbricks.
     */
    public function getNewLines()
    {

        return $this->getSetting('new_lines', 'wpautop');

    }

    /**
     * @return string The ACF type that ultimately decides what kind of field instances of this class is.
     */
    public function getType()
    {

        return 'message';

    }

    /**
     * ACF setting. Allow HTML markup to display as visible text instead of rendering.
     *
     * @param boolean $escapeHtml
     */
    public function setEscapeHtml($escapeHtml)
    {

        $this->setSetting('esc_html', $escapeHtml);

    }

    /**
     * @param $message
     */
    public function setMessage($message)
    {

        $this->setSetting('message', $message);

    }

    /**
     * ACF setting. Controls how new lines are rendered.
     *
     * @param string $newLines "wpautop" (automatically add paragraphs), "br" (automatically add <br>) or "" (no
     *                         formatting)
     */
    public function setNewLines($newLines)
    {

        $this->setSetting('new_lines', $newLines);

    }

}
