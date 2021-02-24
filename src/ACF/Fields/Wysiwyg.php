<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\Field;
use Fewbricks\ACF\FieldInterface;

/**
 * Class Wysiwyg
 * Corresponds to the WYSIWYG field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. Most of the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class Wysiwyg extends Field implements FieldInterface
{

    const TYPE = 'wysiwyg';

    /**
     * @return mixed The value of the ACF setting "default_value". Returns the default ACF value "" if none has been set
     * using Fewbricks.
     */
    public function get_default_value()
    {

        return $this->get_setting('default_value', '');

    }

    /**
     * @return mixed The value of the ACF setting "delay". Returns the default ACF value 0 if none has been set
     * using Fewbricks.
     */
    public function get_delay()
    {

        return $this->get_setting('delay', 0);

    }

    /**
     * @return mixed The value of the ACF setting "media_upload". Returns the default ACF value 1 if none has been set
     * using Fewbricks.
     */
    public function get_media_upload()
    {

        return $this->get_setting('media_upload', 1);

    }

    /**
     * @return mixed The value of the ACF setting "tabs". Returns the default ACF value "all" if none has been set using
     * Fewbricks.
     */
    public function get_tabs()
    {

        return $this->get_setting('tabs', 'all');

    }

    /**
     * @return mixed The value of the ACF setting "toolbar". Returns the default ACF value "full" if none has been set
     * using Fewbricks.
     */
    public function get_toolbar()
    {

        return $this->get_setting('toolbar', 'full');

    }

    /**
     * @param mixed $default_value ACF setting. A default value used by ACF if no value has yet been saved.
     * @return $this
     */
    public function set_default_value($default_value)
    {

        return $this->set_setting('default_value', $default_value);

    }

    /**
     * ACF setting. Set whether TinyMCE should be initialized until field is clicked
     *
     * @param boolean $delay
     * @return $this
     */
    public function set_delay($delay)
    {

        return $this->set_setting('delay', $delay);

    }

    /**
     * ACF setting.
     *
     * @param boolean $media_upload Boolean indicating whether buttons should be shown or not.
     * @return $this
     */
    public function set_media_upload($media_upload)
    {

        return $this->set_setting('media_upload', $media_upload);

    }

    /**
     * ACF settings. Which tabs should be visible.
     *
     * @param string $tabs "visual", "text" or "all" (for both visual and text)
     * @return $this
     */
    public function set_tabs($tabs)
    {

        return $this->set_setting('tabs', $tabs);

    }

    /**
     * ACF setting.
     *
     * @link https://www.advancedcustomfields.com/resources/customize-the-wysiwyg-toolbars/
     *
     * @param string $toolbar "full", "basic" or any custom value added using the filter acf/fields/wysiwyg/toolbars
     * @return $this
     */
    public function set_toolbar($toolbar)
    {

        return $this->set_setting('toolbar', $toolbar);

    }

}
