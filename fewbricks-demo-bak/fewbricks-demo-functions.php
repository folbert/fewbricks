<?php

/**
 * This file contains code that could be put directly in your themes functions.php but I strongly suggest you
 * put it in a dedicated file for setting up Fewbricks. Or, even better, in a class.
 */

namespace App\FewbricksDemo;

use App\FewbricksDemo\Bricks\HeadlineAndText;
use App\FewbricksDemo\Bricks\Wysiwyg;
use App\FewbricksDemo\FieldGroups\Content1;
use App\FewbricksDemo\FieldGroups\FieldsKitchenSink;
use App\FewbricksDemo\FieldGroups\Heroes;
use Fewbricks\ACF\ConditionalLogicRule;
use Fewbricks\ACF\ConditionalLogicRuleGroup;
use Fewbricks\ACF\Field;
use Fewbricks\ACF\FieldGroup;
use Fewbricks\ACF\FieldGroupLocationRuleGroup;
use Fewbricks\ACF\Fields\Text;
use Fewbricks\ACF\Rule;
use Fewbricks\Helper;

// The setup file deals with demo specific functionality so it was moved to own file to keep this file as focused on
// Fewbricks as possible.
require_once 'fewbricks-demo-setup.php';

// Define the filters for the demo
FiltersApplier::defineHooks();

// Demoing an example on how to use "caching" functionality using PHP code files.
// This will use the php code file when in production and run al the code and write to
// the php file when not in production.
if (defined('FEWBRICKS_ENV') && FEWBRICKS_ENV === 'production' && file_exists(Helper::getAutoWritePhpCodeFile())) {

    /** @noinspection PhpIncludeInspection */
    require_once Helper::getAutoWritePhpCodeFile();

} else {

    // Create instance of a field group and register it
    $content1 = new Content1('181201102101a');
    $content1->setTitle('Main content');
    $content1->setMenuOrder(-100);
    $content1->setHideOnScreen('all');
    $content1->setShowOnScreen('permalink');
    $content1->addLocationRuleGroup((new FieldGroupLocationRuleGroup())
        ->addRule(new Rule('post_type', '==', 'fewbricks_demo_pg')));
    $content1->addLocationRuleGroup((
    (new FieldGroupLocationRuleGroup())
        ->addRule(new Rule('post_type', '==', 'fewbricks_demo_pg2'))
    ));
    $content1->register();

    $heroes = new Heroes('1712262204a');
    $heroes->addLocationRuleGroup((new FieldGroupLocationRuleGroup())
        ->addRule(new Rule('post_type', '==', 'fewbricks_demo_pg'))
    );
    $heroes->setHideOnScreen('content');
    $heroes->register();

    (new FieldGroup('Showing ways to add and remove fields', '1801042233a'))
        ->addLocationRuleGroup(
            (new FieldGroupLocationRuleGroup())
                ->addRule(new Rule('post_type', '==', 'fewbricks_demo_pg'))
        )
        ->addLocationRuleGroup(
            (new FieldGroupLocationRuleGroup())
                ->addRule(new Rule('post_type', '==', 'fewbricks_demo_pg2'))
        )
        ->setHideOnScreen('all')
        ->setShowOnScreen('permalink')
        ->setMenuOrder(100)
        ->addArgument('argument_name', 'argument_value')
        ->addArguments([
            'another_argument_name' => 'another_argument_value',
            'yet_another_argument_name' => 'yet_another_argument_value',
        ])
        ->addField(new Text('Text 1', 'text_1', '1801050012a'))
        ->addFields([
            new Text('Text 2', 'text_2', '1801050012b'),
            new Text('Text 3', 'text_3', '1801050012c'),
        ])
        ->addFieldToBeginning(new Text('Text 4', 'text_4', '1801050012d'))
        ->addFieldsToBeginning([
            new Text('Text 5', 'text_5', '1801050012e'),
            new Text('Text 6', 'text_6', '1801050012f'),
        ])
        ->addFieldBeforeByName(new Text('Text 7', 'text_7', '1801050012g'), 'text_3')
        ->addFieldsBeforeByName([
            new Text('Text 8', 'text_8', '1801050012h'),
            new Text('Text 9', 'text_9', '1801050012i'),
        ], 'text_1')
        ->addFieldAfterByName(new Text('Text 10', 'text_10', '1801050012j'), 'text_9')
        ->addFieldsAfterByName([
            new Text('Text 11', 'text_11', '1801050012k'),
            new Text('Text 12', 'text_12', '1801050012l'),
        ], 'text_5')
        ->removeFieldByName('text_9')
        ->removeFieldsByName(['text_11', 'text_4'])
        ->removeFieldByKey('1801050012e')
        ->removeFieldsByKey(['1801050012g', '1801050012b'])
        ->addFieldSetting('1801050012h', 'default_value', 'Default value for Text 8')
        ->addBrick(
            (new HeadlineAndText('headline_and_text_1', 'br1801060137a'))
                ->setFieldLabelsprefix('Headline and text 1 - ')
        )
        ->addBrick(
            (new HeadlineAndText('headline_and_text_2', 'br1801060137b'))
                ->setFieldLabelsprefix('Headline and text 2 - ')
                ->addArgument('show_badge', true)
        )
        ->addBrickToBeginning(
            (new HeadlineAndText('headline_and_text_3', 'br1002121421a'))
                ->setFieldLabelsprefix('Headline and text 3 - ')
                ->addArgument('show_badge', true)
        )
        ->addBrickBeforeByName(
            (new Wysiwyg('wysiwyg_1', 'br1712282146a'))
                ->setFieldLabelsprefix('WYSIWYG 1 - '),
            'text_10'
        )
        ->addBrickAfterByName(
            (new Wysiwyg('wysiwyg2', 'br1712282227u'))
                ->setFieldLabelsprefix('WYSIWYG 2 - ')
                ->addFieldSetting('1712282148a', 'delay', true),  // Setting ACF setting late in the process
            'text_3'
        )
        ->removeBrickByName('headline_and_text_3')
        ->removeBrickByKey('br1712282227u')
        ->register();


    (new FieldGroup('Field group with bricks', 'fg1712282142a'))
        ->addBrick(
            (new Wysiwyg('wysiwyg_1', 'br1712282146a'))
                ->setFieldLabelsprefix('WYSIWYG 1 - ')
        )
        ->addBrick(
            (new Wysiwyg('wysiwyg2', 'br1712282227u'))
                ->setFieldLabelsprefix('WYSIWYG 2 - ')
                ->addFieldSetting('1712282148a', 'delay', true) // Setting ACf setting late in the process
        )
        ->addLocationRuleGroup(
            (new FieldGroupLocationRuleGroup())
                ->addRule(new Rule('post_type', '==', 'fewbricks_demo_pg'))
        )
        ->setHideOnScreen('content')
        ->register();


    // Demoing a class
    (new FieldsKitchenSink('fg1712042021a'))
        ->setTitle('Kitchen sink 1')
        // This will be prefixed to all field names i the field group.
        // Since we are re-using the same field group multiple times on the same page,
        // this is necessary to avoid clashes
        ->setFieldNamesPrefix('main_content_')
        ->register();


    // Demoing the same class but but changing it on the fly
    (new FieldsKitchenSink('fg17120529561a'))
        ->setTitle('Kitchen sink 2')
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
        ->setHideOnScreen('the_content')
        ->setFieldNamesPrefix('secondary_content_')
        ->setFieldLabelsPrefix('Kitchen sink 2 - ')
        ->register();

    // Lots of field groups fo performance tests
    /*(new FieldsKitchenSink('fg1712252102a'))
        ->setFieldNamesPrefix('main_contenta_')
        ->register();
    (new FieldsKitchenSink('fg1712252102b'))
        ->setFieldNamesPrefix('main_contentb_')
        ->register();
    (new FieldsKitchenSink('fg1712252102c'))
        ->setFieldNamesPrefix('main_contentc_')
        ->register();
    (new FieldsKitchenSink('fg1712252102d'))
        ->setFieldNamesPrefix('main_contentd_')
        ->register();
    (new FieldsKitchenSink('fg1712252102e'))
        ->setFieldNamesPrefix('main_contente_')
        ->register();
    (new FieldsKitchenSink('fg1712252102f'))
        ->setFieldNamesPrefix('main_contentf_')
        ->register();*/

}


