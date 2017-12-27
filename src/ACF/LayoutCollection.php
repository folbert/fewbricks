<?php

namespace Fewbricks\ACF;

use Fewbricks\Collection;

/**
 * Class LayoutCollection
 *
 * @package Fewbricks\ACF
 */
class LayoutCollection extends Collection
{

    /**
     * @param string $base_key
     *
     * @return array Associative array with field settings ready to be used for
     * "fields" in an array to be sent to ACFs functions for
     * registering fields using code.
     */
    public function getFinalizedSettings($base_key = '')
    {

        // Lets make sure that the key is ok for ACF
        // https://www.advancedcustomfields.com/resources/register-fields-via-php/#field-settings
        if (substr($base_key, 0, 6) !== 'field_') {
            $base_key = 'field_' . $base_key;
        }

        return $this->finalizeSettings($this->items, $base_key);

    }

    /**
     * @param Layout[] $layoutObjects
     * @param string   $base_key
     *
     * @return array Associative array with field settings ready to be used for
     * "fields" in an array to be sent to ACFs functions for
     * registering fields using code.
     * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/#example
     */
    private function finalizeSettings($layoutObjects, $base_key)
    {

        $settings = [];

        foreach ($layoutObjects AS $key => $layoutObject) {

            $keyPrepend = $base_key;

            // If the field belongs to a brick
            if (false !== ($brickKey = $layoutObject->getBrickKey())) {
                $keyPrepend .= '_' . $brickKey;
            }

            $keyPrepend .= '_';

            $layoutObject->prependKey($keyPrepend);

            $layoutSettings = $layoutObject->getAcfArray();

            $settings[$layoutObject->getKey()] = $layoutSettings;

        }

        return $settings;

    }

    /**
     * @param $name
     */
    public function removeItemByName($name)
    {

        foreach ($this->items AS $key => $item) {

            if ($item->getName() === $name) {

                $this->removeItem($key);

            }

        }

    }


}
