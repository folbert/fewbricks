<?php

/**
 * If you have fields that you are going to use in multiple places, you can define them like this and them reference them
 * using $fewbricks_common_fields['index_of_field']
 */

global $fewbricks_common_fields;

$fewbricks_common_fields = [];

$fewbricks_common_fields['demo_background_color'] = (new \fewbricks\acf\fields\select(
    'Background color', 'demo_background_color', '1509072110d'))->set_settings([
    'choices' => [
        'red' => 'Red',
        'green' => 'Green',
        'blue' => 'Blue'
    ]
]);