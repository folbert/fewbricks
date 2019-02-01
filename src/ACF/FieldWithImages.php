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
    public function get_library()
    {

        return $this->get_setting('library', 'all');

    }

    /**
     * @return mixed The value of the ACF setting "max_height". Returns the default ACF value 0 if none has been
     * set using Fewbricks.
     */
    public function get_max_height()
    {

        return $this->get_setting('max_height', 0);

    }

    /**
     * @return mixed The value of the ACF setting "max_size". Returns the default ACF value 0 if none has been
     * set using Fewbricks.
     */
    public function get_max_size()
    {

        return $this->get_setting('max_size', 0);

    }

    /**
     * @return mixed The value of the ACF setting "max_width". Returns the default ACF value 0 if none has been
     * set using Fewbricks.
     */
    public function get_max_width()
    {

        return $this->get_setting('max_width', 0);

    }

    /**
     * @return mixed The value of the ACF setting "mime_types". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function get_mime_types()
    {

        return $this->get_setting('mime_types', '');

    }

    /**
     * @return mixed The value of the ACF setting "min_height". Returns the default ACF value 0 if none has been
     * set using Fewbricks.
     */
    public function get_min_height()
    {

        return $this->get_setting('min_height', 0);

    }

    /**
     * @return mixed The value of the ACF setting "min_size". Returns the default ACF value 0 if none has been
     * set using Fewbricks.
     */
    public function get_min_size()
    {

        return $this->get_setting('min_size', 0);

    }

    /**
     * @return mixed The value of the ACF setting "min_width". Returns the default ACF value 0 if none has been
     * set using Fewbricks.
     */
    public function get_min_width()
    {

        return $this->get_setting('min_width', 0);

    }

    /**
     * ACF setting. Limit the media library choice.
     *
     * @param $library "all" or "uploadedTo"
     * @return $this
     */
    public function set_library($library)
    {

        return $this->set_setting('library', $library);

    }

    /**
     * ACF setting. Restrict which images can be uploaded.
     *
     * @param int $maxHeight max height in px (without "px")
     * @return $this
     */
    public function set_max_height($maxHeight)
    {

        return $this->set_setting('max_height', $maxHeight);

    }

    /**
     * ACF setting. Restrict which images can be uploaded.
     *
     * @param int $maxSize max size in MB (without "MB")
     * @return $this
     */
    public function set_max_size($maxSize)
    {

        return $this->set_setting('max_size', $maxSize);

    }

    /**
     * ACF setting. Restrict which images can be uploaded.
     *
     * @param int $maxWidth max width in px (without "px")
     * @return $this
     */
    public function set_max_width($maxWidth)
    {

        return $this->set_setting('max_width', $maxWidth);

    }

    /**
     * ACF setting. Don't use or pass an empty value for all types.
     *
     * @param array|string $mimeTypes Comma separated string or array
     * @return $this
     */
    public function set_mime_types($mimeTypes)
    {

        if (is_array($mimeTypes)) {
            $mimeTypes = implode(', ', $mimeTypes);
        }

        return $this->set_setting('mime_types', $mimeTypes);

    }

    /**
     * ACF setting. Restrict which images can be uploaded.
     *
     * @param int $minHeight Min height in px (without "px")
     * @return $this
     */
    public function set_min_height($minHeight)
    {

        return $this->set_setting('min_height', $minHeight);

    }

    /**
     * ACF setting. Restrict which images can be uploaded.
     *
     * @param int $minSize Min size in MB (without "MB")
     * @return $this
     */
    public function set_min_size($minSize)
    {

        return $this->set_setting('min_size', $minSize);

    }

    /**
     * ACF setting. Restrict which images can be uploaded.
     *
     * @param int $minWidth Min width in px (without "px")
     * @return $this
     */
    public function set_min_width($minWidth)
    {

        return $this->set_setting('min_width', $minWidth);

    }

}
