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

    /**
     * @return mixed The value of the ACF setting "center_lat". Returns the default ACF value "-37.81411" if none has
     * been set using Fewbricks.
     */
    public function getCenterLat()
    {

        return $this->getSetting('center_lat', '-37.81411');

    }

    /**
     * @return mixed The value of the ACF setting "center_lng". Returns the default ACF value "144.96328'" if none has
     * been set using Fewbricks.
     */
    public function getCenterLng()
    {

        return $this->getSetting('center_lng', '144.96328');

    }

    /**
     * @return mixed The value of the ACF setting "height". Returns the default ACF value "400" if none has
     * been set using Fewbricks.
     */
    public function getHeight()
    {

        return $this->getSetting('height', '400');

    }

    /**
     * @return string The ACF type that ultimately decides what kind of field instances of this class is.
     */
    public function getType()
    {

        return 'google_map';

    }

    /**
     * @return mixed The value of the ACF setting "zoom". Returns the default ACF value "14" if none has
     * been set using Fewbricks.
     */
    public function getZoom()
    {

        return $this->getSetting('zoom', '14');

    }

    /**
     * ACF setting. Where to center the initial map on the latitude axis.
     *
     * @param int $lat
     */
    public function setCenterLat($lat)
    {

        $this->setSetting('center_lat', $lat);

    }

    /**
     * ACF setting. Where to center the initial map on the latitude axis.
     *
     * @param int $lng
     */
    public function setCenterLng($lng)
    {

        $this->setSetting('center_lng', $lng);

    }

    /**
     * ACF setting. The initial zoom level.
     *
     * @param int $zoom
     */
    public function setZoom($zoom)
    {

        $this->setSetting('zoom', $zoom);

    }

    /**
     * ACF setting. Customize teh map height.
     *
     * @param int $height Height in px (without "px")
     */
    public function setHeight($height)
    {

        $this->setSetting('height', $height);

    }

}
