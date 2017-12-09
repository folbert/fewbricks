<?php

namespace Fewbricks\ACF;

use Fewbricks\Collection;

/**
 * Class FieldCollection
 *
 * @package Fewbricks\ACF
 */
class FieldCollection extends Collection
{

    /**
     * @param string $base_key
     *
     * @return array An array that ACF can work with.
     */
    public function toArray($base_key = '')
    {

        // Lets make sure that the key is ok for ACF
        // https://www.advancedcustomfields.com/resources/register-fields-via-php/#field-settings
        if (substr($base_key, 0, 6) !== 'field_') {
            $base_key = 'field_' . $base_key;
        }

        return $this->finalizeSettings($this->items, $base_key);

    }

    /**
     * @param Field[] $fieldObjects
     * @param string  $base_key
     *
     * @return array Associative array with field settings ready to be used for
     * "fields" in an array to be sent to ACFs functions for
     * registering fields using code.
     * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/#example
     */
    private function finalizeSettings($fieldObjects, $base_key)
    {

        $settings = [];

        foreach ($fieldObjects AS $fieldObject) {

            $keyPrepend = $base_key;

            // If the field belongs to a brick
            if (false !== ($brickKey = $fieldObject->getBrickKey())) {
                $keyPrepend .= '_' . $brickKey;
            }

            $keyPrepend .= '_';

            $fieldObject->prependKey($keyPrepend);

            $settings[] = $fieldObject->toAcfArray();

        }

        $this->prepareFieldsConditionalLogic($fieldObjects);

        return $settings;

    }

    /**
     * @param $fieldObjects
     */
    private function prepareFieldsConditionalLogic($fieldObjects)
    {

        /** @var Field $fieldObject */
        foreach ($fieldObjects AS $fieldObject) {

            $fieldObjectSettings = $fieldObject->toAcfArray();

            // Do the field have conditional logic
            if (isset($fieldObjectSettings['conditional_logic'])
                && is_array($fieldObjectSettings['conditional_logic'])
            ) {

                $conditionalLogic = $fieldObjectSettings['conditional_logic'];

                // Traverse down the conditional logic array
                foreach ($conditionalLogic AS $lvl1Key => $lvl1Value) {

                    foreach (
                        $conditionalLogic[$lvl1Key] AS $lvl2Key => $lvl2Value
                    ) {

                        $targetFieldKey
                            = $conditionalLogic[$lvl1Key][$lvl2Key]['field'];

                        foreach ($this->items AS $otherFieldObject) {

                            if ($otherFieldObject->getOriginalKey()
                                === $targetFieldKey
                            ) {

                                $conditionalLogic[$lvl1Key][$lvl2Key]['field']
                                    = $otherFieldObject->getKey();

                            }

                        }


                    }

                }

                $fieldObject->setSetting('conditional_logic',
                    $conditionalLogic);

            }

        }

    }

}
