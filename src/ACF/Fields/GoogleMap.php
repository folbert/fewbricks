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
     * ACF setting. Where to center the initial map on the latitude axis.
     *
     * @param int $lat
     *
     * @return $this
     */
    public function setCenterLat($lat)
    {

        $this->setSetting('center_lat', $lat);

        return $this;

    }

    /**
     * ACF setting. Where to center the initial map on the latitude axis.
     *
     * @param int $lng
     *
     * @return $this
     */
    public function setCenterLng($lng)
    {

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

        $this->setSetting('height', $height);

        return $this;

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

        $this->setSetting('zoom', $zoom);

        return $this;

    }

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
     * @return mixed The value of the ACF setting "zoom". Returns the default ACF value "14" if none has
     * been set using Fewbricks.
     */
    public function getZoom()
    {

        return $this->getSetting('zoom', '14');

    }

    /**
     * @return string The ACF type that ultimately decides what kind of field instances of this class is.
     */
    public function getType()
    {

        return 'google_map';

    }

}
