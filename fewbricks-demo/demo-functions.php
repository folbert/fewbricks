<?php

/**
 * This file contains code that could be put directly in your themes functions.php-file but I strongly suggest you
 * put it in a dedicated file for setting up Fewbricks or even better in a class.
 */

namespace App\FewbricksDemo;

use App\FewbricksDemo\FieldGroups\FieldsKitchenSink;
use Fewbricks\ACF\ConditionalLogicRule;
use Fewbricks\ACF\ConditionalLogicRuleGroup;
use Fewbricks\ACF\FieldGroupLocationRuleGroup;
use Fewbricks\ACF\Fields\Text;
use Fewbricks\ACF\Rule;
use Fewbricks\Helper;

// The setup file deals with demo specific functionality so it was moved to own file to keep this file as focused on
// Fewbricks as possible.
require_once 'demo-setup.php';

// Define the filters for the demo
Filters::defineHooks();

// Demoing how to use "caching" functionality using PHP code files
if (Helper::getAutoWritePhpCodeFile() !== false) {

    require_once Helper::getAutoWritePhpCodeFile();

} else {

    // Demoing a class
    (new FieldsKitchenSink('1712042021a'))
        ->setTitle('Main content')
        // This will be prefixed to all field names i the field group.
        // Since we are re-using the same field group multiple times on the same page,
        // this is necessary to avoid clashes
        ->setFieldNamesPrefix('main_content_')
        ->register();

    // Demoing the same class but but changing it on the fly
    (new FieldsKitchenSink('17120529561a'))
        ->clearLocationRuleGroups()
        ->addLocationRuleGroups([
            (new FieldGroupLocationRuleGroup())->addRule(
                new Rule('post_type', '=', 'fewbricks_demo_pg2')
            ),
            (new FieldGroupLocationRuleGroup())->addRule(
                new Rule('post_type', '=', 'fewbricks_demo_pg')
            ),
        ])
        ->setTitle('Secondary content')
        ->hideOnScreen('the_content')
        ->setFieldNamesPrefix('secondary_content_')
        ->setFieldLabelsPrefix('Secondary content - ')
        ->register();

    (new FieldsKitchenSink('1712111413a'))
        ->removeField('fd_tab1')
        ->removeFields(['fd_color_picker', 'fd_file'])
        ->removeField('fd_checkbox')
        ->unRemoveField('fd_tab1')
        ->addFieldAfter(
            new Text('Text - added after Button Group', 'fd_text_after_button_group', '1712121051a'),
            'fd_button_group'
        )
        ->addFieldAfter(
            (new Text('Another text added after the button group', 'fd_text_after_new_text', '17121206a'))
                ->addConditionalLogicRuleGroup(
                    (new ConditionalLogicRuleGroup())
                        ->addRule(new ConditionalLogicRule('17120529561a', '==', 'black')
                        )
                ),
            'fd_button_group'
        )
        ->register();

}


