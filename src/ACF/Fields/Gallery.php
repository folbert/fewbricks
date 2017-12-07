<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\FieldInterface;
use Fewbricks\ACF\FieldWithImages;

/**
 * Class Gallery
 * Corresponds to the gallery field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. Most of the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class Gallery extends FieldWithImages implements FieldInterface
{

    /**
     * ACF setting. Specify where new attachments are added
     *
     * @param $insert append or prepend
     *
     * @return $this
     */
    public function setInsert($insert)
    {

        return $this->setSetting('insert', $insert);

    }

    /**
     * ACF setting.
     *
     * @param int $maximumSelection
     *
     * @return $this
     */
    public function setMaximumSelection($maximumSelection)
    {

        return $this->setSetting('max', $maximumSelection);

    }

    /**
     * ACF setting.
     *
     * @param int $minimumSelection
     *
     * @return $this
     */
    public function setMinimumSelection($minimumSelection)
    {

        return $this->setSetting('min', $minimumSelection);

    }

    /**
     * @return string The ACF type that ultimately decides what kind of field instances of this class is.
     */
    public function getType()
    {

        return 'gallery';

    }

}
