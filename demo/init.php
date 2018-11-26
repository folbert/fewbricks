<?php

namespace Fewbricks\Demo;

use Fewbricks\ACF\FieldGroup;
use Fewbricks\ACF\FieldGroupLocationRule;
use Fewbricks\ACF\FieldGroupLocationRuleGroup;
use Fewbricks\ACF\Fields\Text;
use Fewbricks\Helper;

add_filter('fewbricks/dev_tools/display', function () {
    return true;
});

add_filter('fewbricks/dev_tools/acf_arrays/keys', function () {
    return false;
});

add_filter('fewbricks/exporter/auto_write_php_code_file', function() {
    return false;
    //return Helper::getFewbricksInstallPath() . '/gitignored/fewbricks-php.php';
});

add_filter('fewbricks/exporter/display_php_file_written_message', '__return_true');

add_action('fewbricks/init', function () {

    $demo_field_group_1 = new FieldGroup('Demo field group 1', '1811252128a');
    $demo_field_group_1->addLocationRuleGroup(
        (new FieldGroupLocationRuleGroup([
            new FieldGroupLocationRule('post_type', '==', 'post'),
        ]))
    );
    $demo_field_group_1->setDisplayInFewbricksDevTools(true);
    $demo_field_group_1->setHideOnScreen('all');

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
