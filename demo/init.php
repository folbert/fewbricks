<?php

namespace FewbricksDemo;

use Fewbricks\ACF\ConditionalLogicRule;
use Fewbricks\ACF\ConditionalLogicRuleGroup;
use Fewbricks\ACF\FieldGroup;
use Fewbricks\ACF\FieldGroupLocationRule;
use Fewbricks\ACF\FieldGroupLocationRuleGroup;
use Fewbricks\ACF\Fields\Email;
use Fewbricks\ACF\Fields\Link;
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

add_filter('fewbricks/templater/brick_templates_base_path', function () {
    return __DIR__ . '/views/brick-templates';
});

add_filter('fewbricks/templater/brick_layouts_base_path', function() {
    return __DIR__ . '/views/brick-layouts';
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

    $text_field = (new Text('Text field 1', 'text_field_1', '1811262140a'))
        ->setDisplayInFewbricksDevTools(true)
        ->setInstructions('Enter something here to reveal another text field');

    $text_field2 = (new Text('Text field 2', 'text_field_2', '1811262140b'))
        ->addConditionalLogicRuleGroup
        (
            new ConditionalLogicRuleGroup([
                new ConditionalLogicRule('1811262140a', '!=', ''),
            ])
        )
        ->setDisplayInFewbricksDevTools(true);

    $link_field = new Link('Link', 'link', '1811281103a');

    $field_group = (new FieldGroup('Demo field group 1', '1811252128a'))
        ->addLocationRuleGroup
        (
            (new FieldGroupLocationRuleGroup([
                new FieldGroupLocationRule('post_type', '==', 'post'),
            ])),
            (new FieldGroupLocationRuleGroup([
                new FieldGroupLocationRule('post_type', '==', 'page'),
            ]))
        )
        ->setDisplayInFewbricksDevTools(true)
        ->setHideOnScreen('all')
        ->setShowOnScreen('permalink')
        ->addField($text_field)
        ->addField($text_field2)
        ->addFields([
            $link_field,
            new Email('E-mail', 'e_mail', '1811281100a')
        ])
        ->addBrick((new Headline('headline', '1811272140a')))
        ->register();

    (new FieldGroup('Demo field group 2', '1811252128b'))
        ->addLocationRuleGroups(
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
        )
        ->register();

    if(isset($_GET['post'])) {
        //echo get_field('e_mail', $_GET['post']);
    }

});
