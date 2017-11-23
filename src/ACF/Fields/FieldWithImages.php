<?php

namespace Fewbricks\ACF\Fields;

/**
 * Class FieldWithImages
 *
 * @package Fewbricks
 */
class FieldWithImages extends Field
{

    /**
     * ACF setting.
     *
     * @param string $allowedFileTypes . Comma separated list of file endings. Leave blank for all types.
     *
     * @return $this
     */
    public function setAllowedFileTypes($allowedFileTypes)
    {

        return $this->setting('mime_types', $allowedFileTypes);

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

        return $this->setSetting('library', $library);

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

        return $this->setSetting('max_height', $maxHeight);

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

        return $this->setSetting('max_size', $maxSize);

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

        return $this->setSetting('max_width', $maxWidth);

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

        return $this->setSetting('min_height', $minHeight);

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

        return $this->setSetting('min_size', $minSize);

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

        return $this->setSetting('min_width', $minWidth);

    }

}
