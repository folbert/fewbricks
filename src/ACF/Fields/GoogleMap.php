<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\Field;

/**
 * Class GoogleMap
 * Corresponds to the Google Map field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. All the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class GoogleMap extends Field
{

    /**
     * @var string The ACF field type
     */
    protected $type = 'google_map';

    /**
     * ACF setting. Where to center the initial map.
     *
     * @param int $lat
     * @param int $lng
     *
     * @return $this
     */
    public function setCenter($lat, $lng)
    {

        $this->setSetting('center_lat', $lat);
        $this->setSetting('center_lng', $lng);

        return $this;

    }

    /**
     * ACF setting. Customize teh map height.
     *
     * @param int $height Height in px (without "px")
     *
     * @return $this
     */
    public function setHeight($height)
    {

        return $this->setSetting('height', $height);

    }

    /**
     * ACF setting. The initial zoom level.
     *
     * @param int $zoom
     *
     * @return $this
     */
    public function setZoom($zoom)
    {

        return $this->setSetting('zoom', $zoom);

    }

}
