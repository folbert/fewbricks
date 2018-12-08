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
    public function getLibrary()
    {

        return $this->getSetting('library', 'all');

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
     * @return mixed The value of the ACF setting "mime_types". Returns the default ACF value "" if none has been
     * set using Fewbricks.
     */
    public function getMimeTypes()
    {

        return $this->getSetting('mime_types', '');

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
     * @return mixed The value of the ACF setting "return_format". Returns the default ACF value "array" if none has
     * been
     * set using Fewbricks.
     */
    public function getReturnFormat()
    {

        return $this->getSetting('return_format', 'array');

    }

    /**
     * ACF setting. Limit the media library choice.
     *
     * @param string $library "all" or "uploadedTo"
     * @return $this
     */
    public function setLibrary($library)
    {

        return $this->setSetting('library', $library);

    }

    /**
     * ACF setting. Restrict which files can be uploaded.
     *
     * @param int $maxSize Max file size in MB
     * @return $this
     */
    public function setMaxSize($maxSize)
    {

        return $this->setSetting('max_size', $maxSize);

    }

    /**
     * ACF setting. Don't use or pass an empty value for all types.
     *
     * @param string|array $mimeTypes Comma separated string or array
     * @return $this
     */
    public function setMimeTypes($mimeTypes)
    {

        if (is_array($mimeTypes)) {
            $mimeTypes = implode(', ', $mimeTypes);
        }

        return $this->setSetting('mime_types', $mimeTypes);

    }

    /**
     * ACF setting. Restrict which files can be uploaded.
     *
     * @param int $minSize Minimum file size in MB
     * @return $this
     */
    public function setMinSize($minSize)
    {

        return $this->setSetting('min_size', $minSize);

    }

    /**
     * ACF setting. Specify the returned value on front end.
     *
     * @param string $returnFormat "array", "url" or "id"
     * @return $this
     */
    public function setReturnFormat($returnFormat)
    {

        return $this->setSetting('return_format', $returnFormat);

    }

}
