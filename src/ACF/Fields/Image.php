<?php

namespace Fewbricks\ACF\Fields;

/**
 * Class ButtonGroup
 * Corresponds to the image field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. All the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class Image extends FieldWithImages
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

        parent::__construct('image', $label, $name, $key, $settings);

    }

    /**
     * ACF setting. Limit the media library choice.
     *
     * @param string $library "all" or "uploadedTo"
     *
     * @return $this
     */
    public function setLibrary($library)
    {

        return $this->setSetting('library', $library);

    }

    /**
     * ACF setting. Specify the returned value on front end.
     *
     * @param string $returnValue "array", "url" or "id"
     *
     * @return $this
     */
    public function setReturnValue($returnValue)
    {

        return $this->setSetting('return_format', $returnValue);

    }

    /**
     * ACF setting. Shown when entering data
     *
     * @param string $previewSize The name of a defined image size. For example "thumbnail", "medium", "large" or any
     *                            custom image size.
     *
     * @return $this
     */
    public function setPreviewSize($previewSize)
    {

        return $this->setSetting('preview_size', $previewSize);

    }

}
