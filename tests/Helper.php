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
        return $prepend . str_replace('_', '', ucwords($settingsName, '_'));;

    }

    /**
     * @param $object
     * @param array $settings
     */
    public static function applySettings($object, array $settings)
    {

        foreach($settings AS $settingName => $settingValue) {

            if(!in_array($settingName, ['label', 'name', 'key', 'test__key_prefix'])) {

                $functionName = self::settingsNameToFunctionName($settingName, 'set');

                $object->$functionName($settingValue);

            }

        }

    }

}
