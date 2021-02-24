<?php

namespace Fewbricks\Tests;

class Helper
{

    /**
     * @param string $settingsName
     * @return string
     */
    public static function settingsNameToFunctionName(string $settingsName, string $prepend)
    {

        // $settingsName = 'max_value' and $prepend = 'set' would become setMaxValue
        return $prepend . '_' . $settingsName; //str_replace('_', '', ucwords($settingsName, '_'));;

    }

    /**
     * @param $object
     * @param array $settings
     */
    public static function applySettings($object, array $settings, $testObject)
    {

        foreach($settings AS $settingName => $settingValue) {

            if(!in_array($settingName, ['label', 'name', 'key', 'test__key_prefix'])) {

                $functionName = self::settingsNameToFunctionName($settingName, 'set');

                $testObject->assertTrue(
                    method_exists($object, $functionName),
                    get_class($object). ' does not have method ' . $functionName
                );

                $object->$functionName($settingValue);

            }

        }

    }

}
