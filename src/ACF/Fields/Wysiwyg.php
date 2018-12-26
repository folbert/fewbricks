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
     * @return mixed The value of the ACF setting "delay". Returns the default ACF value false if none has been set
     * using Fewbricks.
     */
    public function getDelay()
    {

        return $this->getSetting('delay', false);

    }

    /**
     * @return mixed The value of the ACF setting "media_upload". Returns the default ACF value true if none has been set
     * using Fewbricks.
     */
    public function getMediaUpload()
    {

        return $this->getSetting('media_upload', true);

    }

    /**
     * @return mixed The value of the ACF setting "tabs". Returns the default ACF value "all" if none has been set using
     * Fewbricks.
     */
    public function getTabs()
    {

        return $this->getSetting('tabs', 'all');

    }

    /**
     * @return mixed The value of the ACF setting "toolbar". Returns the default ACF value "full" if none has been set
     * using Fewbricks.
     */
    public function getToolbar()
    {

        return $this->getSetting('toolbar', 'full');

    }

    /**
     * ACF setting. Set whether TinyMCE should be initialized until field is clicked
     *
     * @param boolean $delay
     * @return $this
     */
    public function setDelay($delay)
    {

        return $this->setSetting('delay', $delay);

    }

    /**
     * ACF setting.
     *
     * @param boolean $mediaUpload Boolean indicating whether buttons should be shown or not.
     * @return $this
     */
    public function setMediaUpload($mediaUpload)
    {

        return $this->setSetting('media_upload', $mediaUpload);

    }

    /**
     * ACF settings. Which tabs should be visible.
     *
     * @param string $tabs "visual", "text" or "all" (for both visual and text)
     * @return $this
     */
    public function setTabs($tabs)
    {

        return $this->setSetting('tabs', $tabs);

    }

    /**
     * ACF setting.
     *
     * @link https://www.advancedcustomfields.com/resources/customize-the-wysiwyg-toolbars/
     *
     * @param string $toolbar "full", "basic" or any custom value.
     * @return $this
     */
    public function setToolbar($toolbar)
    {

        return $this->setSetting('toolbar', $toolbar);

    }

}
