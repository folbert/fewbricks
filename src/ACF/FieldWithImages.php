<?php

namespace Fewbricks\ACF;

/**
 * Class FieldWithImages
 *
 * @package Fewbricks
 */
class FieldWithImages extends Field
{

    /**
     * @return mixed The value of the ACF setting "library". Returns the default ACF value "all" if none has been
     * set using Fewbricks.
     */
    public function getLibrary()
    {

        return $this->getSetting('library', 'all');

    }

    /**
     * @return mixed The value of the ACF setting "max_height". Returns the default ACF value "0" if none has been
     * set using Fewbricks.
     */
    public function getMaxHeight()
    {

        $this->getSetting('max_height', 0);

        return $this;

    }

    /**
     * @return mixed The value of the ACF setting "max_size". Returns the default ACF value "0" if none has been
     * set using Fewbricks.
     */
    public function getMaxSize()
    {

        return $this->getSetting('max_size', 0);

    }

    /**
     * @return mixed The value of the ACF setting "max_width". Returns the default ACF value "0" if none has been
     * set using Fewbricks.
     */
    public function getMaxWidth()
    {

        return $this->getSetting('max_width', 0);

    }

    /**
     * @return mixed The value of the ACF setting "mime_types". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function getMimeTypes()
    {

        return $this->getSetting('mime_types', '');

    }

    /**
     * @return mixed The value of the ACF setting "min_height". Returns the default ACF value "0" if none has been
     * set using Fewbricks.
     */
    public function getMinHeight()
    {

        return $this->getSetting('min_height', 0);

    }

    /**
     * @return mixed The value of the ACF setting "min_size". Returns the default ACF value "0" if none has been
     * set using Fewbricks.
     */
    public function getMinSize()
    {

        return $this->getSetting('min_size', 0);

    }

    /**
     * @return mixed The value of the ACF setting "min_width". Returns the default ACF value "0" if none has been
     * set using Fewbricks.
     */
    public function getMinWidth()
    {

        return $this->getSetting('min_width', 0);

    }

    /**
     * ACF setting. Limit the media library choice.
     *
     * @param $library "all" or "uploadedTo"
     *
     * @return $this
     */
    public function setLibrary($library)
    {

        $this->setSetting('library', $library);

        return $this;

    }

    /**
     * ACF setting. Restrict which images can be uploaded.
     *
     * @param int $maxHeight max height in px (without "px")
     *
     * @return $this
     */
    public function setMaxHeight($maxHeight)
    {

        $this->setSetting('max_height', $maxHeight);

        return $this;

    }

    /**
     * ACF setting. Restrict which images can be uploaded.
     *
     * @param int $maxSize max size in MB (without "MB")
     *
     * @return $this
     */
    public function setMaxSize($maxSize)
    {

        $this->setSetting('max_size', $maxSize);

        return $this;

    }

    /**
     * ACF setting. Restrict which images can be uploaded.
     *
     * @param int $maxWidth max width in px (without "px")
     *
     * @return $this
     */
    public function setMaxWidth($maxWidth)
    {

        $this->setSetting('max_width', $maxWidth);

        return $this;

    }

    /**
     * ACF setting. Don't use or pass an empty value for all types.
     *
     * @param array $mime_types Max file size in MB
     *
     * @return $this
     */
    public function setMimeTypes($mime_types)
    {

        if (is_array($mime_types)) {
            $mime_types = implode(', ', $mime_types);
        }

        $this->setSetting('mime_types', $mime_types);

        return $this;

    }

    /**
     * ACF setting. Restrict which images can be uploaded.
     *
     * @param int $minHeight Min height in px (without "px")
     *
     * @return $this
     */
    public function setMinHeight($minHeight)
    {

        $this->setSetting('min_height', $minHeight);

        return $this;

    }

    /**
     * ACF setting. Restrict which images can be uploaded.
     *
     * @param int $minSize Min size in MB (without "MB")
     *
     * @return $this
     */
    public function setMinSize($minSize)
    {

        $this->setSetting('min_size', $minSize);

        return $this;

    }

    /**
     * ACF setting. Restrict which images can be uploaded.
     *
     * @param int $minWidth Min width in px (without "px")
     *
     * @return $this
     */
    public function setMinWidth($minWidth)
    {

        $this->setSetting('min_width', $minWidth);

        return $this;

    }

}
