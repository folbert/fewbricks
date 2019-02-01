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

    const TYPE = 'image';

    /**
     * @return mixed The value of the ACF setting "preview_size". Returns the default ACF value "thumbnail" if none has been
     * set using Fewbricks.
     */
    public function get_preview_size()
    {

        return $this->get_setting('preview_size', 'thumbnail');

    }

    /**
     * @return mixed The value of the ACF setting "return_format". Returns the default ACF value "array" if none has been
     * set using Fewbricks.
     */
    public function get_return_format()
    {

        return $this->get_setting('return_format', 'array');

    }

    /**
     * ACF setting. Shown when entering data
     *
     * @param string $preview_size The name of a defined image size. For example "thumbnail", "medium", "large" or any
     *                            custom image size.
     * @return $this
     */
    public function set_preview_size($preview_size)
    {

        return $this->set_setting('preview_size', $preview_size);

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
