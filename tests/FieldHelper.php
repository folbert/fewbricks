<?php

namespace Fewbricks\Tests;

class FieldHelper {

    /**
     * @param string $fieldClassName
     * @param array $args
     * @return mixed
     */
    public static function createFieldObject(string $fieldClassName, array $args)
    {

        return new $fieldClassName($args['label'], $args['name'], $args['key']);

    }

    /**
     * @param string $class
     * @param array $settings
     * @return mixed
     */
    public static function getCompleteFieldObject(string $class, array $settings)
    {

        $constructorArgsNames = ['label', 'name', 'key'];
        $constructorArgs = [];

        foreach($constructorArgsNames AS $constructorArgName) {

            $constructorArgs[$constructorArgName] = $settings[$constructorArgName];

        }

        $textField = FieldHelper::createFieldObject($class, $constructorArgs);

        Helper::applySettings($textField, $settings);

        return $textField;

    }

    /**
     * @param $fieldObject
     * @param $settings
     * @return mixed
     */
    public static function getExpectedFieldValues($fieldObject, array $settings)
    {

        $expectedValues = $settings;

        $expectedValues['key'] = 'field_' . $expectedValues['test__key_prefix'] . '_' . $settings['key'];
        $expectedValues['fewbricks__original_key'] = $settings['key'];
        $expectedValues['fewbricks__parents'] = [];
        $expectedValues['type'] = $fieldObject->getType();

        // We wont expect these indexes
        unset($expectedValues['test__key_prefix']);

        return $expectedValues;

    }

}
