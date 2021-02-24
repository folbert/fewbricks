<?php

namespace Fewbricks\Tests\ACF;

use Fewbricks\ACF\FieldGroup;
use Fewbricks\ACF\FieldGroupLocationRule;
use Fewbricks\ACF\FieldGroupLocationRuleGroup;
use Fewbricks\ACF\Fields\Text;
use Fewbricks\ACF\RuleGroupCollection;
use Fewbricks\Exceptions\DuplicateKeyException;
use Fewbricks\Tests\TextAndUrlBrick;
use PHPUnit\Framework\TestCase;

final class FieldGroupTest extends TestCase
{

    /**
     *
     */
    public function testClassExists()
    {
        $this->assertTrue(class_exists('Fewbricks\ACF\FieldGroup'));
    }

    /**
     *
     */
    public function testSetTitle()
    {

        $title = 'A test field group';

        $fieldGroup = new FieldGroup($title, '');

        $this->assertArraySubset([
            'title' => $title,
        ],
            $fieldGroup->to_acf_array()
        );

    }

    /**
     *
     */
    public function testGetTitle()
    {

        $title = 'A test field group';

        $fieldGroup = new FieldGroup($title, '');

        $this->assertEquals($title, $fieldGroup->get_title());

    }

    /**
     *
     */
    public function testSetKey()
    {

        $key = '1812110742a';

        $fieldGroup = new FieldGroup('', $key);

        $this->assertArraySubset([
            'key' => 'group_' . $key,
        ],
            $fieldGroup->to_acf_array()
        );

    }

    /**
     *
     */
    public function testGetKey()
    {

        $key = '1812110742a';

        $fieldGroup = new FieldGroup('', $key);

        $this->assertEquals($key, $fieldGroup->get_key());

    }

    /**
     *
     */
    public function testAddLocationRules()
    {

        $fieldGroup = new FieldGroup('', '');

        $fieldGroup->add_location_rule_group(
            (new FieldGroupLocationRuleGroup())
                ->add_field_group_location_rule(
                    new FieldGroupLocationRule('post_type', '==', 'post')
                )
                ->add_field_group_location_rule(
                    new FieldGroupLocationRule('post_type', '==', 'page')
                )
        );

        $fieldGroup->add_location_rule_group(
            (new FieldGroupLocationRuleGroup())
                ->add_field_group_location_rule(
                    new FieldGroupLocationRule('user_role', '!=', 'administrator')
                )
        );

        $acfArray = $fieldGroup->to_acf_array();

        $this->assertEquals([
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'post',
                ],
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'page',
                ]
            ],
            [
                [
                    'param' => 'user_role',
                    'operator' => '!=',
                    'value' => 'administrator',
                ]
            ]
        ],
            $acfArray['location']
        );

    }

    public function testGetLocationRuleGroups()
    {

        $fieldGroup = new FieldGroup('', '');

        $fieldGroup->add_location_rule_group(
            (new FieldGroupLocationRuleGroup())
                ->add_field_group_location_rule(
                    new FieldGroupLocationRule('post_type', '==', 'post')
                )
                ->add_field_group_location_rule(
                    new FieldGroupLocationRule('post_type', '==', 'page')
                )
        );

        $fieldGroup->add_location_rule_group(
            (new FieldGroupLocationRuleGroup())
                ->add_field_group_location_rule(
                    new FieldGroupLocationRule('user_role', '!=', 'administrator')
                )
        );

        $this->assertInstanceOf(RuleGroupCollection::class, $fieldGroup->get_location_rulegroups());

        $this->assertEquals([
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'post',
                ],
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'page',
                ]
            ],
            [
                [
                    'param' => 'user_role',
                    'operator' => '!=',
                    'value' => 'administrator',
                ]
            ]
        ],
            $fieldGroup->get_location_rulegroups()->to_array()
        );

    }

    /**
     *
     */
    public function testRemovingFieldByKey()
    {

        $fieldGroup = new FieldGroup('', '1812112150a');

        $fieldGroup->add_field(
            (new Text('A textfield', 'a_textfield', '1812112152a'))
        );

        $fieldGroup->add_field(
            (new Text('Text to be removed by key', 'removed_by_key', '1812112152d'))
        );

        $fieldGroup->add_field(
            (new Text('Another textfield', 'another_textfield2000', '1812112152b'))
        );

        $fieldGroup->remove_field_by_key('1812112152d');

        $acfArray = $fieldGroup->to_acf_array('1812112152b');

        $this->assertEquals(
            [
                [
                    'key' => 'field_1812112152b_1812112152a',
                    'label' => 'A textfield',
                    'name' => 'a_textfield',
                    'fewbricks__original_key' => '1812112152a',
                    'fewbricks__parents' => [],
                    'type' => 'text',
                ],
                [
                    'key' => 'field_1812112152b_1812112152b',
                    'label' => 'Another textfield',
                    'name' => 'another_textfield2000',
                    'fewbricks__original_key' => '1812112152b',
                    'fewbricks__parents' => [],
                    'type' => 'text',
                ],
            ],
            $acfArray['fields']
        );

    }

    /**
     *
     */
    public function testRemovingFieldByName()
    {

        $fieldGroup = new FieldGroup('', '1812112150a');

        $fieldGroup->add_field(
            (new Text('A textfield', 'a_textfield', '1812112152a'))
        );

        $fieldGroup->add_field(
            (new Text('Text to be removed by name', 'removed_by_name', '1812112152c'))
        );

        $fieldGroup->add_field(
            (new Text('Another textfield', 'another_textfield2000', '1812112152b'))
        );

        $fieldGroup->remove_field_by_name('removed_by_name');

        $acfArray = $fieldGroup->to_acf_array('1812112152b');

        $this->assertEquals(
            [
                [
                    'key' => 'field_1812112152b_1812112152a',
                    'label' => 'A textfield',
                    'name' => 'a_textfield',
                    'fewbricks__original_key' => '1812112152a',
                    'fewbricks__parents' => [],
                    'type' => 'text',
                ],
                [
                    'key' => 'field_1812112152b_1812112152b',
                    'label' => 'Another textfield',
                    'name' => 'another_textfield2000',
                    'fewbricks__original_key' => '1812112152b',
                    'fewbricks__parents' => [],
                    'type' => 'text',
                ],
            ],
            $acfArray['fields']
        );

    }

    /**
     *
     */
    public function testRemovingBrickByName()
    {

        $fieldGroup = new FieldGroup('', '1812112150a');

        $fieldGroup->add_field(
            (new Text('A textfield', 'a_textfield', '1812112152a'))
        );

        $fieldGroup->add_brick(
            (new TextAndUrlBrick('1812180917a', 'image_n_text'))
        );

        $fieldGroup->add_brick(
            new TextAndUrlBrick('1812112247a', 'brick_to_be_removed_by_name')
        );

        $fieldGroup->add_brick(
            new TextAndUrlBrick('1812112248a', 'to_be_kept')
        );

        $fieldGroup->remove_brick_by_name('brick_to_be_removed_by_name');

        $acfArray = $fieldGroup->to_acf_array('1812112152b');

        $this->assertEquals(
            [
                [
                    'key' => 'field_1812112152b_1812112152a',
                    'label' => 'A textfield',
                    'name' => 'a_textfield',
                    'fewbricks__original_key' => '1812112152a',
                    'fewbricks__parents' => [],
                    'type' => 'text',
                ],
                [
                    'key' => 'field_1812112152b_1812180917a_imageandtextbrickfield_text_key',
                    'label' => 'A text',
                    'name' => 'image_n_text_my_text',
                    'fewbricks__original_key' => 'imageandtextbrickfield_text_key',
                    'fewbricks__parents' => [
                        [
                            'key' => '1812180917a',
                            'name' => 'image_n_text',
                            'type' => 'brick',
                        ]
                    ],
                    'type' => 'text',
                ],
                [
                    'key' => 'field_1812112152b_1812180917a_imageandtextbrickfield_url_key',
                    'label' => 'The URL',
                    'name' => 'image_n_text_my_url',
                    'fewbricks__original_key' => 'imageandtextbrickfield_url_key',
                    'fewbricks__parents' => [
                        [
                            'key' => '1812180917a',
                            'name' => 'image_n_text',
                            'type' => 'brick',
                        ]
                    ],
                    'type' => 'url',
                ],
                [
                    'key' => 'field_1812112152b_1812112248a_imageandtextbrickfield_text_key',
                    'label' => 'A text',
                    'name' => 'to_be_kept_my_text',
                    'fewbricks__original_key' => 'imageandtextbrickfield_text_key',
                    'fewbricks__parents' => [
                        [
                            'key' => '1812112248a',
                            'name' => 'to_be_kept',
                            'type' => 'brick',
                        ]
                    ],
                    'type' => 'text',
                ],
                [
                    'key' => 'field_1812112152b_1812112248a_imageandtextbrickfield_url_key',
                    'label' => 'The URL',
                    'name' => 'to_be_kept_my_url',
                    'fewbricks__original_key' => 'imageandtextbrickfield_url_key',
                    'fewbricks__parents' => [
                        [
                            'key' => '1812112248a',
                            'name' => 'to_be_kept',
                            'type' => 'brick',
                        ]
                    ],
                    'type' => 'url',
                ],
            ],
            $acfArray['fields']
        );

    }

    /**
     *
     */
    public function testRemovingBrickByKey()
    {

        $fieldGroup = new FieldGroup('', '1812112150a');

        $fieldGroup->add_field(
            (new Text('A textfield', 'a_textfield', '1812112152a'))
        );

        $fieldGroup->add_brick(
            (new TextAndUrlBrick('1812180917b', 'image_n_text'))
        );

        $fieldGroup->add_brick(
            new TextAndUrlBrick('1812112247b', 'to_be_removed_by_key')
        );

        $fieldGroup->add_brick(
            new TextAndUrlBrick('1812112248a', 'to_be_kept')
        );

        $fieldGroup->remove_brick_by_key('1812112247b');

        $acfArray = $fieldGroup->to_acf_array('1812112152b');

        $this->assertEquals(
            [
                [
                    'key' => 'field_1812112152b_1812112152a',
                    'label' => 'A textfield',
                    'name' => 'a_textfield',
                    'fewbricks__original_key' => '1812112152a',
                    'fewbricks__parents' => [],
                    'type' => 'text',
                ],
                [
                    'key' => 'field_1812112152b_1812180917b_imageandtextbrickfield_text_key',
                    'label' => 'A text',
                    'name' => 'image_n_text_my_text',
                    'fewbricks__original_key' => 'imageandtextbrickfield_text_key',
                    'fewbricks__parents' => [
                        [
                            'key' => '1812180917b',
                            'name' => 'image_n_text',
                            'type' => 'brick',
                        ]
                    ],
                    'type' => 'text',
                ],
                [
                    'key' => 'field_1812112152b_1812180917b_imageandtextbrickfield_url_key',
                    'label' => 'The URL',
                    'name' => 'image_n_text_my_url',
                    'fewbricks__original_key' => 'imageandtextbrickfield_url_key',
                    'fewbricks__parents' => [
                        [
                            'key' => '1812180917b',
                            'name' => 'image_n_text',
                            'type' => 'brick',
                        ]
                    ],
                    'type' => 'url',
                ],
                [
                    'key' => 'field_1812112152b_1812112248a_imageandtextbrickfield_text_key',
                    'label' => 'A text',
                    'name' => 'to_be_kept_my_text',
                    'fewbricks__original_key' => 'imageandtextbrickfield_text_key',
                    'fewbricks__parents' => [
                        [
                            'key' => '1812112248a',
                            'name' => 'to_be_kept',
                            'type' => 'brick',
                        ]
                    ],
                    'type' => 'text',
                ],
                [
                    'key' => 'field_1812112152b_1812112248a_imageandtextbrickfield_url_key',
                    'label' => 'The URL',
                    'name' => 'to_be_kept_my_url',
                    'fewbricks__original_key' => 'imageandtextbrickfield_url_key',
                    'fewbricks__parents' => [
                        [
                            'key' => '1812112248a',
                            'name' => 'to_be_kept',
                            'type' => 'brick',
                        ]
                    ],
                    'type' => 'url',
                ],
            ],
            $acfArray['fields']
        );

    }

    public function testAddBrick()
    {

        $fieldGroup = new FieldGroup('', '1812112150a');

        $fieldGroup->add_field(
            (new Text('A textfield', 'a_textfield', '1812112152a'))
        );

        $fieldGroup->add_brick(
            (new TextAndUrlBrick('1812180917c', 'image_n_text'))
        );

        $fieldGroup->add_brick(
            new TextAndUrlBrick('1812112248a', 'to_be_kept')
        );

        $acfArray = $fieldGroup->to_acf_array('1812112152b');

        $this->assertEquals(
            [
                [
                    'key' => 'field_1812112152b_1812112152a',
                    'label' => 'A textfield',
                    'name' => 'a_textfield',
                    'fewbricks__original_key' => '1812112152a',
                    'fewbricks__parents' => [],
                    'type' => 'text',
                ],
                [
                    'key' => 'field_1812112152b_1812180917c_imageandtextbrickfield_text_key',
                    'label' => 'A text',
                    'name' => 'image_n_text_my_text',
                    'fewbricks__original_key' => 'imageandtextbrickfield_text_key',
                    'fewbricks__parents' => [
                        [
                            'key' => '1812180917c',
                            'name' => 'image_n_text',
                            'type' => 'brick',
                        ]
                    ],
                    'type' => 'text',
                ],
                [
                    'key' => 'field_1812112152b_1812180917c_imageandtextbrickfield_url_key',
                    'label' => 'The URL',
                    'name' => 'image_n_text_my_url',
                    'fewbricks__original_key' => 'imageandtextbrickfield_url_key',
                    'fewbricks__parents' => [
                        [
                            'key' => '1812180917c',
                            'name' => 'image_n_text',
                            'type' => 'brick',
                        ]
                    ],
                    'type' => 'url',
                ],
                [
                    'key' => 'field_1812112152b_1812112248a_imageandtextbrickfield_text_key',
                    'label' => 'A text',
                    'name' => 'to_be_kept_my_text',
                    'fewbricks__original_key' => 'imageandtextbrickfield_text_key',
                    'fewbricks__parents' => [
                        [
                            'key' => '1812112248a',
                            'name' => 'to_be_kept',
                            'type' => 'brick',
                        ]
                    ],
                    'type' => 'text',
                ],
                [
                    'key' => 'field_1812112152b_1812112248a_imageandtextbrickfield_url_key',
                    'label' => 'The URL',
                    'name' => 'to_be_kept_my_url',
                    'fewbricks__original_key' => 'imageandtextbrickfield_url_key',
                    'fewbricks__parents' => [
                        [
                            'key' => '1812112248a',
                            'name' => 'to_be_kept',
                            'type' => 'brick',
                        ]
                    ],
                    'type' => 'url',
                ],
            ],
            $acfArray['fields']
        );

    }

    /**
     *
     */
    public function testInsertBeforeFieldByName()
    {

        $fieldGroup = new FieldGroup('', '');

        $fieldGroup->add_field(
            new Text('Text field 2', 'text_field_2', '1812112259a')
        );

        $fieldGroup->add_field_before_field_by_name(
            new Text('Text field 1', 'text_field_1', '1812112259b'),
            'text_field_2'
        );

        $acfArray = $fieldGroup->to_acf_array();

        $this->assertEquals([
            [
                'key' => 'field_1812112259b',
                'label' => 'Text field 1',
                'name' => 'text_field_1',
                'fewbricks__original_key' => '1812112259b',
                'fewbricks__parents' => [],
                'type' => 'text',
            ],
            [
                'key' => 'field_1812112259a',
                'label' => 'Text field 2',
                'name' => 'text_field_2',
                'fewbricks__original_key' => '1812112259a',
                'fewbricks__parents' => [],
                'type' => 'text',
            ],
        ], $acfArray['fields']);

    }

    /**
     *
     */
    public function testReplaceFieldByKey()
    {

        $fieldGroup = new FieldGroup('', '');

        $fieldGroup->add_field(
            new Text('Text field 1', 'text_field_1', '1812112259a')
        );

        $fieldGroup->add_field(
            new Text('Text field 2', 'text_field_2', '1812112259b')
        );

        $fieldGroup->add_field(
            new Text('Text field 3', 'text_field_3', '1812112259c')
        );

        $fieldGroup->replace_field_by_key(
            new Text('Text field 4', 'text_field_4', '1812112259d'),
            '1812112259b'
        );

        $acfArray = $fieldGroup->to_acf_array();

        $this->assertEquals([
            [
                'key' => 'field_1812112259a',
                'label' => 'Text field 1',
                'name' => 'text_field_1',
                'fewbricks__original_key' => '1812112259a',
                'fewbricks__parents' => [],
                'type' => 'text',
            ],
            [
                'key' => 'field_1812112259d',
                'label' => 'Text field 4',
                'name' => 'text_field_4',
                'fewbricks__original_key' => '1812112259d',
                'fewbricks__parents' => [],
                'type' => 'text',
            ],
            [
                'key' => 'field_1812112259c',
                'label' => 'Text field 3',
                'name' => 'text_field_3',
                'fewbricks__original_key' => '1812112259c',
                'fewbricks__parents' => [],
                'type' => 'text',
            ],
        ], $acfArray['fields']);

    }

    public function testInsertAfterFieldByName()
    {

        $fieldGroup = new FieldGroup('', '');

        $fieldGroup->add_field(
            new Text('Text field 1', 'text_field_1', '1812112259a')
        );

        $fieldGroup->add_field(
            new Text('Text field 3', 'text_field_3', '1812112259b')
        );

        $fieldGroup->add_field_after_field_by_name(
            new Text('Text field 2', 'text_field_2', '1812112259c'),
            'text_field_1'
        );

        $acfArray = $fieldGroup->to_acf_array();

        $this->assertEquals([
            [
                'key' => 'field_1812112259a',
                'label' => 'Text field 1',
                'name' => 'text_field_1',
                'fewbricks__original_key' => '1812112259a',
                'fewbricks__parents' => [],
                'type' => 'text',
            ],
            [
                'key' => 'field_1812112259c',
                'label' => 'Text field 2',
                'name' => 'text_field_2',
                'fewbricks__original_key' => '1812112259c',
                'fewbricks__parents' => [],
                'type' => 'text',
            ],
            [
                'key' => 'field_1812112259b',
                'label' => 'Text field 3',
                'name' => 'text_field_3',
                'fewbricks__original_key' => '1812112259b',
                'fewbricks__parents' => [],
                'type' => 'text',
            ],
        ], $acfArray['fields']);

    }

    /**
     *
     */
    public function XtestDuplicateKeys()
    {

        $this->expectException(DuplicateKeyException::class);

        $fieldGroup = new FieldGroup('', '1812112150a');

        $fieldGroup->add_field(
            (new Text('A textfield', 'a_textfield', '1812112152a'))
        );

        $fieldGroup->add_field(
            (new Text('Another textfield', 'another_textfield', '1812112152a'))
        );

    }

    /**
     *
     */
    public function testHideOnScreen_All()
    {

        $fieldGroup = new FieldGroup('', '');

        $fieldGroup->set_hide_on_screen('all');

        $this->assertEquals([
            'permalink',
            'the_content',
            'excerpt',
            'custom_fields',
            'discussion',
            'comments',
            'revisions',
            'slug',
            'author',
            'format',
            'page_attributes',
            'featured_image',
            'categories',
            'tags',
            'send-trackbacks',
        ], $fieldGroup->to_acf_array()['hide_on_screen']);

    }

    /**
     *
     */
    public function testHideOnScreen_SingleItem()
    {

        $fieldGroup = new FieldGroup('', '');

        $fieldGroup->set_hide_on_screen('comments');
        $fieldGroup->set_hide_on_screen('slug'); // This is the one we will expect

        $this->assertEquals([
            'slug',
        ], $fieldGroup->to_acf_array()['hide_on_screen']);

    }

    /**
     *
     */
    public function testHideOnScreen_MultipleItems()
    {

        $fieldGroup = new FieldGroup('', '');

        $fieldGroup->set_hide_on_screen('all');
        $fieldGroup->set_hide_on_screen(['comments', 'permalink', 'format']);

        $this->assertEquals([
            'comments',
            'permalink',
            'format',
        ], $fieldGroup->to_acf_array()['hide_on_screen']);

    }

    /**
     *
     */
    public function testShowOnScreen_All()
    {

        $fieldGroup = new FieldGroup('', '');

        $fieldGroup->set_hide_on_screen('all');
        $fieldGroup->set_show_on_screen('all');

        $this->assertEquals([
        ], $fieldGroup->to_acf_array()['hide_on_screen']);

    }

    /**
     *
     */
    public function testShowOnScreen_SingleItem()
    {

        $fieldGroup = new FieldGroup('', '');

        $fieldGroup->set_hide_on_screen(['comments', 'permalink', 'format', 'page_attributes']);
        $fieldGroup->set_show_on_screen(['format', 'page_attributes']);

        $this->assertEquals([
            'comments',
            'permalink',
        ], $fieldGroup->to_acf_array()['hide_on_screen']);

    }

    /**
     *
     */
    public function testShowOnScreen_MultipleItems()
    {

        $fieldGroup = new FieldGroup('', '');

        $fieldGroup->set_hide_on_screen(['comments', 'permalink', 'format', 'page_attributes']);
        $fieldGroup->set_show_on_screen(['format', 'page_attributes']);

        $this->assertEquals([
            'comments',
            'permalink',
        ], $fieldGroup->to_acf_array()['hide_on_screen']);

    }

    public function testSetActive()
    {

        $fieldGroup = new FieldGroup('', '');

        $fieldGroup->set_active(false);
        $this->assertEquals(false, $fieldGroup->get_active());

        $fieldGroup->set_active(true);
        $this->assertEquals(true, $fieldGroup->get_active());

    }

    public function testSetDescription()
    {

        $description = 'A description dy9823dgod';

        $fieldGroup = new FieldGroup('', '');

        $fieldGroup->set_description($description);

        $this->assertEquals($description, $fieldGroup->get_description());

    }

    public function testSetInstructionPlacement()
    {

        // Its ok to send any value
        $instructionPlacement = 'banana';

        $fieldGroup = new FieldGroup('', '');

        $fieldGroup->set_instruction_placement($instructionPlacement);

        $this->assertEquals($instructionPlacement, $fieldGroup->get_instruction_placement());

    }

    public function testSetLabelPlacement()
    {

        // Its ok to send any value
        $labelPlacement = 'orange';

        $fieldGroup = new FieldGroup('', '');

        $fieldGroup->set_label_placement($labelPlacement);

        $this->assertEquals($labelPlacement, $fieldGroup->get_label_placement());

    }

    public function testSetMenuOrder()
    {

        // Its ok to send any value
        $menuOrder = 10;

        $fieldGroup = new FieldGroup('', '');

        $fieldGroup->set_menu_order($menuOrder);

        $this->assertEquals($menuOrder, $fieldGroup->get_menu_order());

    }

    public function testSetPosition()
    {

        // Its ok to send any value
        $position = 'pear';

        $fieldGroup = new FieldGroup('', '');

        $fieldGroup->set_position($position);

        $this->assertEquals($position, $fieldGroup->get_position());

    }

    public function testset_setting()
    {

        // Its ok to send any value
        $settingName = 'pear';
        $settingValue = 'kiwi';

        $fieldGroup = new FieldGroup('', '');

        $fieldGroup->set_setting($settingName, $settingValue);

        $this->assertEquals($settingValue, $fieldGroup->get_setting($settingName));

    }

    public function testGetSettingDefaultValue()
    {

        $settingName = 'setting_name_d9dg';
        $defaultValue = 'default_value_jd98ydoh';

        $fieldGroup = new FieldGroup('', '');

        $this->assertEquals($defaultValue, $fieldGroup->get_setting($settingName, $defaultValue));

    }

    public function testGetSettings()
    {

        $settings = [
            'setting_name_1' => 'setting_value_1',
            'setting_name_2' => 'setting_value_2',
        ];

        $fieldGroup = new FieldGroup('', '');

        $fieldGroup->set_setting('setting_name_1', $settings['setting_name_1']);
        $fieldGroup->set_setting('setting_name_2', $settings['setting_name_2']);

        $this->assertEquals($settings, $fieldGroup->get_settings());

    }

    public function testSetStyle()
    {

        // Its ok to send any value
        $style = 'dover_calais';

        $fieldGroup = new FieldGroup('', '');

        $fieldGroup->set_style($style);

        $this->assertEquals($style, $fieldGroup->get_style());

    }

    public function testSetFieldLabelPrefix()
    {

        $labelPrefix = 'A prefix dg78iku-';

        $fieldGroup = new FieldGroup('', '');

        $fieldGroup->add_field(new Text('Text field', 'text_field', '1812132221a'));
        $fieldGroup->add_field(new Text('Text field 2', 'text_field_2', '1812132221b'));

        $fieldGroup->set_field_labels_prefix($labelPrefix);

        $this->assertArraySubset(
            [
                [
                    'label' => $labelPrefix . 'Text field',
                ],
                [
                    'label' => $labelPrefix . 'Text field 2',
                ]
            ],
            $fieldGroup->to_acf_array()['fields']
        );

    }

    public function testSetFieldLabelSuffix()
    {

        $labelSuffix = '-A suffix g78fi';

        $fieldGroup = new FieldGroup('', '');

        $fieldGroup->add_field(new Text('Text field', 'text_field', '1812132221a'));
        $fieldGroup->add_field(new Text('Text field 2', 'text_field_2', '1812132221b'));

        $fieldGroup->set_field_labels_suffix($labelSuffix);

        $this->assertArraySubset(
            [
                [
                    'label' => 'Text field' . $labelSuffix,
                ],
                [
                    'label' => 'Text field 2' . $labelSuffix,
                ]
            ],
            $fieldGroup->to_acf_array()['fields']
        );

    }

    /**
     *
     */
    public function testRegister()
    {

        $fieldGroup = new FieldGroup('A field group', '1812132149a');

        $fieldGroup->add_field(new Text('Text field 1', 'text_field_1', '1812132204a'));
        $fieldGroup->set_display_in_fewbricks_info_pane(true);
        $fieldGroup->set_setting('setting_1_name', 'setting_1_value');
        $fieldGroup->set_menu_order(78);
        $fieldGroup->set_position('the_position_dgigk');
        $fieldGroup->set_label_placement('the_label_placement_y8yo');
        $fieldGroup->set_description('Description d98sgl');
        $fieldGroup->set_instruction_placement('Instruction placement dh8gol');
        $fieldGroup->set_active(false);
        $fieldGroup->set_hide_on_screen('all');
        $fieldGroup->set_show_on_screen('slug');
        $fieldGroup->set_style('dover_calais');
        $fieldGroup->set_title('A new title dy8ohl');

        $this->assertEquals([
            'key' => 'group_1812132149a',
            'title' => 'A new title dy8ohl',
            'location' => [],
            'fewbricks__display_in_info_pane' => true,
            'setting_1_name' => 'setting_1_value',
            'menu_order' => 78,
            'position' => 'the_position_dgigk',
            'label_placement' => 'the_label_placement_y8yo',
            'description' => 'Description d98sgl',
            'instruction_placement' => 'Instruction placement dh8gol',
            'active' => false,
            'hide_on_screen' => [],
            'style' => 'dover_calais',
            'hide_on_screen' => [
                0 => 'permalink',
                1 => 'the_content',
                2 => 'excerpt',
                3 => 'custom_fields',
                4 => 'discussion',
                5 => 'comments',
                6 => 'revisions',
                8 => 'author',
                9 => 'format',
                10 => 'page_attributes',
                11 => 'featured_image',
                12 => 'categories',
                13 => 'tags',
                14 => 'send-trackbacks',
            ],
            'fields' => [
                [
                    'key' => 'field_1812132204a',
                    'label' => 'Text field 1',
                    'name' => 'text_field_1',
                    'fewbricks__original_key' => '1812132204a',
                    'fewbricks__parents' => [],
                    'type' => 'text',
                ]
            ],
        ],
            $fieldGroup->register(false)->to_acf_array()
        );

    }

    public function testSetShowInFewbricksInfoPane()
    {

        $fieldGroup = new FieldGroup('', '');

        $fieldGroup->set_display_in_fewbricks_info_pane(true);

        $this->assertEquals(true, $fieldGroup->get_display_in_fewbricks_info_pane());

    }


}
