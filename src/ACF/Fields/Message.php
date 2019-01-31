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

    const TYPE = 'message';

    /**
     * @return mixed The value of the ACF setting "esc_html". Returns the default ACF value 0 if none has been
     * set using Fewbricks.
     */
    public function get_esc_html()
    {

        return $this->get_setting('esc_html', 0);

    }

    /**
     * @return mixed The value of the ACF setting "message". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function get_message()
    {

        return $this->get_setting('message', '');

    }

    /**
     * @return mixed The value of the ACF setting "new_lines". Returns the default ACF value "wpautop" if none has been
     * set using Fewbricks.
     */
    public function get_new_lines()
    {

        return $this->get_setting('new_lines', 'wpautop');

    }

    /**
     * ACF setting. Allow HTML markup to display as visible text instead of rendering.
     *
     * @param boolean $escapeHtml
     * @return $this
     */
    public function set_esc_html($escapeHtml)
    {

        return $this->set_setting('esc_html', $escapeHtml);

    }

    /**
     * @param $message
     * @return $this
     */
    public function set_message($message)
    {

        return $this->set_setting('message', $message);

    }

    /**
     * ACF setting. Controls how new lines are rendered.
     *
     * @param string $newLines "wpautop" (automatically add paragraphs), "br" (automatically add <br>) or "" (no
     * formatting)
     * @return $this
     */
    public function set_new_lines($newLines)
    {

        return $this->set_setting('new_lines', $newLines);

    }

}
