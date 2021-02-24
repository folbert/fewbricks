<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\Field;
use Fewbricks\ACF\FieldInterface;

/**
 * Class File
 * Corresponds to the file field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. Most of the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class File extends Field implements FieldInterface
{

    const TYPE = 'file';

    /**
     * @return mixed The value of the ACF setting "library". Returns the default ACF value "all" if none has been
     * set using Fewbricks.
     */
    public function get_library()
    {

        return $this->get_setting('library', 'all');

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
     * @return mixed The value of the ACF setting "mime_types". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function get_mime_types()
    {

        return $this->get_setting('mime_types', '');

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
     * @return mixed The value of the ACF setting "return_format". Returns the default ACF value "array" if none has
     * been
     * set using Fewbricks.
     */
    public function get_return_format()
    {

        return $this->get_setting('return_format', 'array');

    }

    /**
     * ACF setting. Limit the media library choice.
     *
     * @param string $library "all" or "uploadedTo"
     * @return $this
     */
    public function set_library($library)
    {

        return $this->set_setting('library', $library);

    }

    /**
     * ACF setting. Restrict which files can be uploaded.
     *
     * @param int $max_size Max file size in MB
     * @return $this
     */
    public function set_max_size($max_size)
    {

        return $this->set_setting('max_size', $max_size);

    }

    /**
     * ACF setting. Don't use or pass an empty value for all types.
     *
     * @param string|array $mime_types Comma separated string or array
     * @return $this
     */
    public function set_mime_types($mime_types)
    {

        if (is_array($mime_types)) {
            $mime_types = implode(', ', $mime_types);
        }

        return $this->set_setting('mime_types', $mime_types);

    }

    /**
     * ACF setting. Restrict which files can be uploaded.
     *
     * @param int $min_size Minimum file size in MB
     * @return $this
     */
    public function set_min_size($min_size)
    {

        return $this->set_setting('min_size', $min_size);

    }

    /**
     * ACF setting. Specify the returned value on front end.
     *
     * @param string $return_format "array", "url" or "id"
     * @return $this
     */
    public function set_return_format($return_format)
    {

        return $this->set_setting('return_format', $return_format);

    }

}
