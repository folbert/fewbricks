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

        $this->setSetting('insert', $insert);

        return $this;

    }

    /**
     * ACF setting maximum selection.
     *
     * @param int $max
     *
     * @return $this
     */
    public function setMax($max)
    {

        $this->setSetting('max', $max);

        return $this;

    }

    /**
     * ACF setting minimum selection.
     *
     * @param int $min
     *
     * @return $this
     */
    public function setMin($min)
    {

        $this->setSetting('min', $min);

        return $this;

    }

    /**
     * @return mixed The value of the ACF setting "insert". Returns the default ACF value "append" if none has been
     * set using Fewbricks.
     */
    public function getInsert()
    {

        return $this->getSetting('insert', 'append');

    }

    /**
     * @return mixed The value of the ACF setting "max". Returns the default ACF value "0" if none has been
     * set using Fewbricks.
     */
    public function getMax()
    {

        return $this->getSetting('max', 0);

    }

    /**
     * @return mixed The value of the ACF setting "min". Returns the default ACF value "0" if none has been
     * set using Fewbricks.
     */
    public function getMin()
    {

        return $this->getSetting('min', 0);

    }

    /**
     * @return string The ACF type that ultimately decides what kind of field instances of this class is.
     */
    public function getType()
    {

        return 'gallery';

    }

}
