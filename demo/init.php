<?php

namespace FewbricksDemo;

use Fewbricks\ACF\ConditionalLogicRule;
use Fewbricks\ACF\ConditionalLogicRuleGroup;
use Fewbricks\ACF\FieldGroup;
use Fewbricks\ACF\FieldGroupLocationRule;
use Fewbricks\ACF\FieldGroupLocationRuleGroup;
use Fewbricks\ACF\Fields\Text;
use Fewbricks\Helper;
use FewbricksDemo\Bricks\Headline;

spl_autoload_register(function ($class) {

    $class_namespace_parts = explode('\\', $class);

    // Make sure we are dealing with our namespace
    if (substr($class, 0, strlen(__NAMESPACE__)) === __NAMESPACE__) {

        $path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR;
        $path .= implode(DIRECTORY_SEPARATOR, array_slice($class_namespace_parts, 1)) . '.php';

        /** @noinspection PhpIncludeInspection */
        include $path;

    }

});

add_filter('fewbricks/bricks/templates_base_path', function() {
    return __DIR__ . '/lib/bricks';
});

add_filter('fewbricks/dev_tools/display', function () {
    return true;
});

add_filter('fewbricks/dev_tools/acf_arrays/keys', function () {
    return false;
});

add_filter('fewbricks/exporter/auto_write_php_code_file', function () {
    return false;
    //return Helper::getFewbricksInstallPath() . '/gitignored/fewbricks-php.php';
});

add_filter('fewbricks/exporter/display_php_file_written_message', '__return_true');

add_action('fewbricks/init', function () {

    $demo_field_group_1 = new FieldGroup('Demo field group 1', '1811252128a');
    /*$demo_field_group_1->addLocationRuleGroup(
        (new FieldGroupLocationRuleGroup([
            new FieldGroupLocationRule('post_type', '==', 'post'),
        ]))
    );*/
    $demo_field_group_1->addLocationRuleGroup(
        (new FieldGroupLocationRuleGroup([
            new FieldGroupLocationRule('post_type', '==', 'post'),
        ])),
        (new FieldGroupLocationRuleGroup([
            new FieldGroupLocationRule('post_type', '==', 'page'),
        ]))
    );
    $demo_field_group_1->setDisplayInFewbricksDevTools(true);
    $demo_field_group_1->setHideOnScreen('all');

    $text_field = new Text('Text field', 'text_field', '1811262140a');
    $text_field->setDisplayInFewbricksDevTools(true);
    $demo_field_group_1->addField($text_field);

    $text_field2 = new Text('Text field', 'text_field', '1811262140b');
    $text_field2->addConditionalLogicRuleGroup(
        new ConditionalLogicRuleGroup([
            new ConditionalLogicRule('1811262140a', '!=', ''),
        ])
    );
    $text_field2->setDisplayInFewbricksDevTools(true);
    $demo_field_group_1->addField($text_field2);

    $demo_field_group_1->addBrick(
        (new Headline('headline', '1811272140a'))
    );

    $demo_field_group_1->register();

    $demo_field_group_2 = new FieldGroup('Demo field group 2', '1811252128b');
    $demo_field_group_2->addLocationRuleGroups(
        [
            (new FieldGroupLocationRuleGroup(
                [
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

});
