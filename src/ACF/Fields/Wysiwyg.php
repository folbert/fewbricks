<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\Field;

/**
 * Class Wysiwyg
 * Corresponds to the WYSIWYG field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. All the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class Wysiwyg extends Field
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

        parent::__construct('wysiwyg', $label, $name, $key, $settings);

    }

    /**
     * ACF setting. Set whether TinyMCE should be initialized until field is clicked
     *
     * @param boolean $delay
     *
     * @return $this
     */
    public function setDelay($delay)
    {

        return $this->setSetting('delay', $delay);

    }

    /**
     * ACF settings. Which tabs should be visible.
     *
     * @param string $tabs "visual", "text" or "all" (for both visual and text)
     *
     * @return $this
     */
    public function setTabs($tabs)
    {

        return $this->setSetting('tabs', $tabs);

    }

    /**
     * ACF setting.
     *
     * @param string $toolbar "full", "basic" or any custom value.
     *
     * @link https://www.advancedcustomfields.com/resources/customize-the-wysiwyg-toolbars/
     *
     * @return $this
     */
    public function setToolbar($toolbar)
    {

        return $this->setSetting('toolbar', $toolbar);

    }

    /**
     * ACF setting.
     *
     * @param boolean $showMediaUploadButtons Boolean indicating whether buttons should be shown or not.
     *
     * @return $this
     */
    public function showMediaUploadButtons($showMediaUploadButtons)
    {

        return $this->setSetting('media_upload', $showMediaUploadButtons);

    }

}
