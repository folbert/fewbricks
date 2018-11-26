<?php

namespace Fewbricks\Demo;

use Fewbricks\ACF\FieldGroup;
use Fewbricks\ACF\FieldGroupLocationRule;
use Fewbricks\ACF\FieldGroupLocationRuleGroup;
use Fewbricks\ACF\Fields\Text;

add_filter('fewbricks/dev_tools/display', function () {
    return 33;
});

add_filter('fewbricks/dev_tools/acf_arrays/keys', function () {
    return false;
});

add_action('fewbricks/init', function () {

    $demo_field_group_1 = new FieldGroup('Demo field group 1', '1811252128a');
    $demo_field_group_1->addLocationRuleGroup(
        (new FieldGroupLocationRuleGroup([
            new FieldGroupLocationRule('post_type', '==', 'post'),
        ]))
    );
    $demo_field_group_1->setDisplayInFewbricksDevTools(true);

    $text_field = new Text('Text field', 'text_field', '1811262140a');
    $text_field->setDisplayInFewbricksDevTools(true);

    $demo_field_group_1->addField($text_field);
    $demo_field_group_1->register();

    $demo_field_group_2 = new FieldGroup('Demo field group 2', '1811252128b');
    $demo_field_group_2->addLocationRuleGroups(
        [
            (new FieldGroupLocationRuleGroup(
                [
                    new FieldGroupLocationRule('post_type', '==', 'post'),
                    new FieldGroupLocationRule('post_type', '==', 'page'),
                ]
            )),
            (new FieldGroupLocationRuleGroup(
                [
                    new FieldGroupLocationRule('post_type', '==', 'post'),
                ]
            ))
        ]
    );
    $demo_field_group_2->register();

    new Text('A text field', 'atextfield', 'hdudkj');

});
