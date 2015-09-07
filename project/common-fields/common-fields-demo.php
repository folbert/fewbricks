<?php

global $fewbricks_common_fields;

$fewbricks_common_fields = [];

$fewbricks_common_fields['demo_background_color'] = (new \fewbricks\acf\fields\select(
    'Background color', 'background_color', '1509072110d'))->set_settings([
        'choices' => [
            'red' => 'Red',
            'green' => 'Green',
            'blue' => 'Blue'
        ]
]);