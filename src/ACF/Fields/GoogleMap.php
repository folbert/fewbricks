<?php

namespace Fewbricks\ACF\Fields;

use Fewbricks\ACF\Field;
use Fewbricks\ACF\FieldInterface;

/**
 * Class GoogleMap
 * Corresponds to the Google Map field type in ACF.
 * This class is more or less completely stupid and only exists
 * to accommodate quicker creation especially if you are using
 * a real IDE with auto completion. Most of the magic takes place in the
 * Field class.
 *
 * @package Fewbricks\ACF\Fields
 */
class GoogleMap extends Field implements FieldInterface
{

    const TYPE = 'google_map';

    /**
     * @return mixed The value of the ACF setting "center_lat". Returns the default ACF value "" if none has
     * been set using Fewbricks.
     */
    public function getCenterLat()
    {

        return $this->getSetting('center_lat', '');

    }

    /**
     * @return mixed The value of the ACF setting "center_lng". Returns the default ACF value "'" if none has
     * been set using Fewbricks.
     */
    public function getCenterLng()
    {

        return $this->getSetting('center_lng', '');

    }

    /**
     * @return mixed The value of the ACF setting "height". Returns the default ACF value "" if none has
     * been set using Fewbricks.
     */
    public function getHeight()
    {

        return $this->getSetting('height', '');

    }

    /**
     * @return mixed The value of the ACF setting "zoom". Returns the default ACF value "" if none has
     * been set using Fewbricks.
     */
    public function getZoom()
    {

        return $this->getSetting('zoom', '');

    }

    /**
     * ACF setting. Where to center the initial map on the latitude axis.
     *
     * @param int $lat
     * @return $this
     */
    public function setCenterLat($lat)
    {

        return $this->setSetting('center_lat', $lat);

    }

    /**
     * ACF setting. Where to center the initial map on the latitude axis.
     *
     * @param int $lng
     * @return $this
     */
    public function setCenterLng($lng)
    {

        return $this->setSetting('center_lng', $lng);

    }

    /**
     * ACF setting. The initial zoom level.
     *
     * @param int $zoom
     * @return $this
     */
    public function setZoom($zoom)
    {

        return $this->setSetting('zoom', $zoom);

    }

    /**
     * ACF setting. Customize the map height.
     *
     * @param int $height Height in px (without "px")
     * @return $this
     */
    public function setHeight($height)
    {

        return $this->setSetting('height', $height);

    }

}
