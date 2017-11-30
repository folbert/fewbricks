<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\Field;

/**
 * Class Oembed
 * Corresponds to the Oembed field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. All the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class Oembed extends Field
{

    /**
     * @var string The ACF field type
     */
    protected $type = 'oembed';

    /**
     * ACF setting.
     *
     * @param int $width  Width in px (without "px")
     * @param int $height Hieght in px (without "px")
     *
     * @return $this
     */
    public function setEmbedSize($width, $height)
    {

        return $this->setSettings(['width' => $width, 'height' => $height]);

    }

}
