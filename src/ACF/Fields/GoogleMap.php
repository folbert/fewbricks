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
     * @param string $label    The label of the field
     * @param string $name     The name of the field
     * @param string $key      The key of the field. Must be unique across the
     *                         entire app
     * @param array  $settings Array where you can pass all the possible
     *                         settings for the field.
     *                         https://www.advancedcustomfields.com/resources/register-fields-via-php/#field-type%20settings
     * @param array  $void     Not used. Exists only to match the nr of args of parent
     *                         constructor.
     */
    public function __construct(
        $label,
        $name,
        $key,
        $settings = [],
        $void = null
    ) {

        parent::__construct('google_map', $label, $name, $key, $settings);

    }

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
