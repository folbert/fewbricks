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

    /**
     * @return string The ACF type that ultimately decides what kind of field instances of this class is.
     */
    public function getType()
    {

        return 'file';

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
     * ACF setting. Restrict which files can be uploaded.
     *
     * @param int $max_size Max file size in MB
     *
     * @return $this
     */
    public function setMaxSize($max_size)
    {

        return $this->setSetting('max_size', $max_size);

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

        if(is_array($mime_types)) {
            $mime_types = implode(', ', $mime_types);
        }

        return $this->setSetting('mime_types', $mime_types);

    }

    /**
     * ACF setting. Restrict which files can be uploaded.
     *
     * @param int $min_size Minimum file size in MB
     *
     * @return $this
     */
    public function setMinSize($min_size)
    {

        return $this->setSetting('min_size', $min_size);

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

        return $this->setSetting('return_format', $returnFormat);

    }

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
     * @return mixed The value of the ACF setting "return_format". Returns the default ACF value "d/m/Y" if none has been
     * set using Fewbricks.
     */
    public function getReturnFormat()
    {

        return $this->getSetting('return_format', 'd/m/Y');

    }

}
