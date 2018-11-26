<?php

namespace Fewbricks\Demo;

use Fewbricks\ACF\FieldGroup;
use Fewbricks\ACF\FieldGroupLocationRule;
use Fewbricks\ACF\FieldGroupLocationRuleGroup;
use Fewbricks\ACF\Fields\Text;

add_filter('fewbricks/dev_tools/display', function() {
    return 70;
});

add_filter('fewbricks/dev_tools/keys', function() {

    return 'group_1811252128b';

});

add_action('fewbricks/init', function () {

    $demo_field_group_1 = new FieldGroup('Demo field group 1', '1811252128a');
    $demo_field_group_1->addLocationRuleGroup(
        (new FieldGroupLocationRuleGroup([
            new FieldGroupLocationRule('post_type', '==', 'post'),
        ]))
    );
    $demo_field_group_1->register();

    $demo_field_group_2 = new FieldGroup('Demo field group 2', '1811252128b');
    $demo_field_group_2->addLocationRuleGroup(
        (new FieldGroupLocationRuleGroup([
            new FieldGroupLocationRule('post_type', '==', 'post'),
        ]))
    );
    $demo_field_group_2->register();

    new Text('A text field', 'atextfield', 'hdudkj');

});
