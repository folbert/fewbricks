<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\FieldInterface;
use Fewbricks\ACF\FieldWithImages;

/**
 * Class ButtonGroup
 * Corresponds to the image field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. Most of the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class Image extends FieldWithImages implements FieldInterface
{

    /**
     * @return mixed The value of the ACF setting "preview_size". Returns the default ACF value "thumbnail" if none has been
     * set using Fewbricks.
     */
    public function getPreviewSize()
    {

        return $this->getSetting('preview_size', 'thumbnail');

    }

    /**
     * @return mixed The value of the ACF setting "return_format". Returns the default ACF value "array" if none has been
     * set using Fewbricks.
     */
    public function getReturnFormat()
    {

        return $this->getSetting('return_format', 'array');

    }

    /**
     * @return string The ACF type that ultimately decides what kind of field instances of this class is.
     */
    public function getType()
    {

        return 'image';

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

        $this->setSetting('preview_size', $previewSize);

        return $this;

    }

    /**
     * ACF setting. Specify the returned value on front end.
     *
     * @param string $returnFormat "array", "url" or "id"
     *
     * @return $this
     */
    public function setReturnFormat($returnFormat)
    {

        $this->setSetting('return_format', $returnFormat);

        return $this;

    }

}
