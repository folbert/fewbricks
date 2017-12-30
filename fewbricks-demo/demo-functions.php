<?php

/**
 * This file contains code that could be put directly in your themes functions.php-file but I strongly suggest you
 * put it in a dedicated file for setting up Fewbricks or even better in a class.
 */

namespace App\FewbricksDemo;

use App\FewbricksDemo\Bricks\Wysiwyg;
use App\FewbricksDemo\FieldGroups\FieldsKitchenSink;
use App\FewbricksDemo\FieldGroups\Heroes;
use Fewbricks\ACF\ConditionalLogicRule;
use Fewbricks\ACF\ConditionalLogicRuleGroup;
use Fewbricks\ACF\FieldGroup;
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
if (defined('FEWBRICKS_ENV') && FEWBRICKS_ENV === 'production') {

    //dump('Using file');
    require_once Helper::getAutoWritePhpCodeFile();

} else {

    //dump('Loading all code');

    (new Heroes('1712262204a'))
        ->addLocationRuleGroup(
            (new FieldGroupLocationRuleGroup())
                ->addRule(new Rule('post_type', '==', 'fewbricks_demo_pg'))
        )
        ->hideOnScreen('content')
        ->register();

    (new FieldGroup('fg1712282142a'))
        ->setTitle('Field group with bricks')
        ->addBrick(
            (new Wysiwyg('wysiwyg_1', 'br1712282146a'))
                ->setFieldLabelsPrefix('WYSIWYG 1 - ')
        )
        ->addBrick(
            (new Wysiwyg('wysiwyg2', 'br1712282227u'))
                ->setFieldLabelsPrefix('WYSIWYG 2 - ')
                ->addFieldSetting('1712282148a', 'delay', true) // Setting ACf setting late in the process
        )
        ->addLocationRuleGroup(
            (new FieldGroupLocationRuleGroup())
                ->addRule(new Rule('post_type', '==', 'fewbricks_demo_pg'))
        )
        ->hideOnScreen('content')
        ->register();

    // Demoing a class
    (new FieldsKitchenSink('fg1712042021a'))
        ->setTitle('Main content')
        // This will be prefixed to all field names i the field group.
        // Since we are re-using the same field group multiple times on the same page,
        // this is necessary to avoid clashes
        ->setFieldNamesPrefix('main_content_')
        ->setArg('remove_layouts', ['fd_text_and_select', 'fd_single_image'])
        ->setArg('remove_sub_fields', ['fd_repeater_image', 'fd_repeater_text_2'])
        ->register();

    // Demoing the same class but but changing it on the fly
    (new FieldsKitchenSink('fg17120529561a'))
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

    (new FieldsKitchenSink('fg1712111413a'))
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
                        ->addRule(new ConditionalLogicRule('1711172249u', '==', 'black')
                        )
                ),
            'fd_button_group'
        )
        ->register();


    // Lots of field groups fo perf tests
    /*(new FieldsKitchenSink('fg1712252102a'))
        ->setTitle('Main content')
        ->setFieldNamesPrefix('main_contenta_')
        ->register();
    (new FieldsKitchenSink('fg1712252102b'))
        ->setTitle('Main content')
        ->setFieldNamesPrefix('main_contentb_')
        ->register();
    (new FieldsKitchenSink('fg1712252102c'))
        ->setTitle('Main content')
        ->setFieldNamesPrefix('main_contentc_')
        ->register();
    (new FieldsKitchenSink('fg1712252102d'))
        ->setTitle('Main content')
        ->setFieldNamesPrefix('main_contentd_')
        ->register();
    (new FieldsKitchenSink('fg1712252102e'))
        ->setTitle('Main content')
        ->setFieldNamesPrefix('main_contente_')
        ->register();
    (new FieldsKitchenSink('fg1712252102f'))
        ->setTitle('Main content')
        ->setFieldNamesPrefix('main_contentf_')
        ->register();*/

}


