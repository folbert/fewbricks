<?php

namespace Fewbricks\Demo;

use Fewbricks\ACF\FieldGroup;
use Fewbricks\ACF\Fields\Text;

add_action('fewbricks/init', function() {

    $demo_field_group_1 = new FieldGroup('Demo field group 1', '1811252128a');

    new Text('A text field', 'atextfield', 'hdudkj');

});
