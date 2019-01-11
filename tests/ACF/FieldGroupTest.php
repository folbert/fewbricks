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
            $fieldGroup->toAcfArray()
        );

    }

    /**
     *
     */
    public function testGetTitle()
    {

        $title = 'A test field group';

        $fieldGroup = new FieldGroup($title, '');

        $this->assertEquals($title, $fieldGroup->getTitle());

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
            $fieldGroup->toAcfArray()
        );

    }

    /**
     *
     */
    public function testGetKey()
    {

        $key = '1812110742a';

        $fieldGroup = new FieldGroup('', $key);

        $this->assertEquals($key, $fieldGroup->getKey());

    }

    /**
     *
     */
    public function testAddLocationRules()
    {

        $fieldGroup = new FieldGroup('', '');

        $fieldGroup->addLocationRuleGroup(
            (new FieldGroupLocationRuleGroup())
                ->addFieldGroupLocationRule(
                    new FieldGroupLocationRule('post_type', '==', 'post')
                )
                ->addFieldGroupLocationRule(
                    new FieldGroupLocationRule('post_type', '==', 'page')
                )
        );

        $fieldGroup->addLocationRuleGroup(
            (new FieldGroupLocationRuleGroup())
                ->addFieldGroupLocationRule(
                    new FieldGroupLocationRule('user_role', '!=', 'administrator')
                )
        );

        $acfArray = $fieldGroup->toAcfArray();

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

        $fieldGroup->addLocationRuleGroup(
            (new FieldGroupLocationRuleGroup())
                ->addFieldGroupLocationRule(
                    new FieldGroupLocationRule('post_type', '==', 'post')
                )
                ->addFieldGroupLocationRule(
                    new FieldGroupLocationRule('post_type', '==', 'page')
                )
        );

        $fieldGroup->addLocationRuleGroup(
            (new FieldGroupLocationRuleGroup())
                ->addFieldGroupLocationRule(
                    new FieldGroupLocationRule('user_role', '!=', 'administrator')
                )
        );

        $this->assertInstanceOf(RuleGroupCollection::class, $fieldGroup->getLocationRuleGroups());

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
            $fieldGroup->getLocationRuleGroups()->toArray()
        );

    }

    /**
     *
     */
    public function testRemovingFieldByKey()
    {

        $fieldGroup = new FieldGroup('', '1812112150a');

        $fieldGroup->addField(
            (new Text('A textfield', 'a_textfield', '1812112152a'))
        );

        $fieldGroup->addField(
            (new Text('Text to be removed by key', 'removed_by_key', '1812112152d'))
        );

        $fieldGroup->addField(
            (new Text('Another textfield', 'another_textfield2000', '1812112152b'))
        );

        $fieldGroup->removeFieldByKey('1812112152d');

        $acfArray = $fieldGroup->toAcfArray('1812112152b');

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

        $fieldGroup->addField(
            (new Text('A textfield', 'a_textfield', '1812112152a'))
        );

        $fieldGroup->addField(
            (new Text('Text to be removed by name', 'removed_by_name', '1812112152c'))
        );

        $fieldGroup->addField(
            (new Text('Another textfield', 'another_textfield2000', '1812112152b'))
        );

        $fieldGroup->removeFieldByName('removed_by_name');

        $acfArray = $fieldGroup->toAcfArray('1812112152b');

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

        $fieldGroup->addField(
            (new Text('A textfield', 'a_textfield', '1812112152a'))
        );

        $fieldGroup->addBrick(
            (new TextAndUrlBrick('image_n_text', '1812112239a'))
        );

        $fieldGroup->addBrick(
            new TextAndUrlBrick('brick_to_be_removed_by_name', '1812112247a')
        );

        $fieldGroup->addBrick(
            new TextAndUrlBrick('to_be_kept', '1812112248a')
        );

        $fieldGroup->removeBrickByName('brick_to_be_removed_by_name');

        $acfArray = $fieldGroup->toAcfArray('1812112152b');

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
                    'key' => 'field_1812112152b_1812112239a_imageandtextbrickfield_text_key',
                    'label' => 'A text',
                    'name' => 'image_n_text_my_text',
                    'fewbricks__original_key' => 'imageandtextbrickfield_text_key',
                    'fewbricks__parents' => [
                        [
                            'key' => '1812112239a',
                            'name' => 'image_n_text',
                            'type' => 'brick',
                        ]
                    ],
                    'type' => 'text',
                ],
                [
                    'key' => 'field_1812112152b_1812112239a_imageandtextbrickfield_url_key',
                    'label' => 'The URL',
                    'name' => 'image_n_text_my_url',
                    'fewbricks__original_key' => 'imageandtextbrickfield_url_key',
                    'fewbricks__parents' => [
                        [
                            'key' => '1812112239a',
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

        $fieldGroup->addField(
            (new Text('A textfield', 'a_textfield', '1812112152a'))
        );

        $fieldGroup->addBrick(
            (new TextAndUrlBrick('image_n_text', '1812112239a'))
        );

        $fieldGroup->addBrick(
            new TextAndUrlBrick('to_be_removed_by_key', '1812112247b')
        );

        $fieldGroup->addBrick(
            new TextAndUrlBrick('to_be_kept', '1812112248a')
        );

        $fieldGroup->removeBrickByKey('1812112247b');

        $acfArray = $fieldGroup->toAcfArray('1812112152b');

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
                    'key' => 'field_1812112152b_1812112239a_imageandtextbrickfield_text_key',
                    'label' => 'A text',
                    'name' => 'image_n_text_my_text',
                    'fewbricks__original_key' => 'imageandtextbrickfield_text_key',
                    'fewbricks__parents' => [
                        [
                            'key' => '1812112239a',
                            'name' => 'image_n_text',
                            'type' => 'brick',
                        ]
                    ],
                    'type' => 'text',
                ],
                [
                    'key' => 'field_1812112152b_1812112239a_imageandtextbrickfield_url_key',
                    'label' => 'The URL',
                    'name' => 'image_n_text_my_url',
                    'fewbricks__original_key' => 'imageandtextbrickfield_url_key',
                    'fewbricks__parents' => [
                        [
                            'key' => '1812112239a',
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

        $fieldGroup->addField(
            (new Text('A textfield', 'a_textfield', '1812112152a'))
        );

        $fieldGroup->addBrick(
            (new TextAndUrlBrick('image_n_text', '1812112239a'))
        );

        $fieldGroup->addBrick(
            new TextAndUrlBrick('to_be_kept', '1812112248a')
        );

        $acfArray = $fieldGroup->toAcfArray('1812112152b');

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
                    'key' => 'field_1812112152b_1812112239a_imageandtextbrickfield_text_key',
                    'label' => 'A text',
                    'name' => 'image_n_text_my_text',
                    'fewbricks__original_key' => 'imageandtextbrickfield_text_key',
                    'fewbricks__parents' => [
                        [
                            'key' => '1812112239a',
                            'name' => 'image_n_text',
                            'type' => 'brick',
                        ]
                    ],
                    'type' => 'text',
                ],
                [
                    'key' => 'field_1812112152b_1812112239a_imageandtextbrickfield_url_key',
                    'label' => 'The URL',
                    'name' => 'image_n_text_my_url',
                    'fewbricks__original_key' => 'imageandtextbrickfield_url_key',
                    'fewbricks__parents' => [
                        [
                            'key' => '1812112239a',
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

        $fieldGroup->addField(
            new Text('Text field 2', 'text_field_2', '1812112259a')
        );

        $fieldGroup->addFieldBeforeFieldByName(
            new Text('Text field 1', 'text_field_1', '1812112259b'),
            'text_field_2'
        );

        $acfArray = $fieldGroup->toAcfArray();

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

        $fieldGroup->addField(
            new Text('Text field 1', 'text_field_1', '1812112259a')
        );

        $fieldGroup->addField(
            new Text('Text field 2', 'text_field_2', '1812112259b')
        );

        $fieldGroup->addField(
            new Text('Text field 3', 'text_field_3', '1812112259c')
        );

        $fieldGroup->replaceFieldByKey(
            new Text('Text field 4', 'text_field_4', '1812112259d'),
            '1812112259b'
        );

        $acfArray = $fieldGroup->toAcfArray();

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

        $fieldGroup->addField(
            new Text('Text field 1', 'text_field_1', '1812112259a')
        );

        $fieldGroup->addField(
            new Text('Text field 3', 'text_field_3', '1812112259b')
        );

        $fieldGroup->addFieldAfterFieldByName(
            new Text('Text field 2', 'text_field_2', '1812112259c'),
            'text_field_1'
        );

        $acfArray = $fieldGroup->toAcfArray();

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
    public function testDuplicateKeys()
    {

        $this->expectException(DuplicateKeyException::class);

        $fieldGroup = new FieldGroup('', '1812112150a');

        $fieldGroup->addField(
            (new Text('A textfield', 'a_textfield', '1812112152a'))
        );

        $fieldGroup->addField(
            (new Text('Another textfield', 'another_textfield', '1812112152a'))
        );

    }

    /**
     *
     */
    public function testHideOnScreen_All()
    {

        $fieldGroup = new FieldGroup('', '');

        $fieldGroup->setHideOnScreen('all');

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
        ], $fieldGroup->toAcfArray()['hide_on_screen']);

    }

    /**
     *
     */
    public function testHideOnScreen_SingleItem()
    {

        $fieldGroup = new FieldGroup('', '');

        $fieldGroup->setHideOnScreen('comments');
        $fieldGroup->setHideOnScreen('slug'); // This is the one we will expect

        $this->assertEquals([
            'slug',
        ], $fieldGroup->toAcfArray()['hide_on_screen']);

    }

    /**
     *
     */
    public function testHideOnScreen_MultipleItems()
    {

        $fieldGroup = new FieldGroup('', '');

        $fieldGroup->setHideOnScreen('all');
        $fieldGroup->setHideOnScreen(['comments', 'permalink', 'format']);

        $this->assertEquals([
            'comments',
            'permalink',
            'format',
        ], $fieldGroup->toAcfArray()['hide_on_screen']);

    }

    /**
     *
     */
    public function testShowOnScreen_All()
    {

        $fieldGroup = new FieldGroup('', '');

        $fieldGroup->setHideOnScreen('all');
        $fieldGroup->setShowOnScreen('all');

        $this->assertEquals([
        ], $fieldGroup->toAcfArray()['hide_on_screen']);

    }

    /**
     *
     */
    public function testShowOnScreen_SingleItem()
    {

        $fieldGroup = new FieldGroup('', '');

        $fieldGroup->setHideOnScreen(['comments', 'permalink', 'format', 'page_attributes']);
        $fieldGroup->setShowOnScreen(['format', 'page_attributes']);

        $this->assertEquals([
            'comments',
            'permalink',
        ], $fieldGroup->toAcfArray()['hide_on_screen']);

    }

    /**
     *
     */
    public function testShowOnScreen_MultipleItems()
    {

        $fieldGroup = new FieldGroup('', '');

        $fieldGroup->setHideOnScreen(['comments', 'permalink', 'format', 'page_attributes']);
        $fieldGroup->setShowOnScreen(['format', 'page_attributes']);

        $this->assertEquals([
            'comments',
            'permalink',
        ], $fieldGroup->toAcfArray()['hide_on_screen']);

    }

    public function testSetActive()
    {

        $fieldGroup = new FieldGroup('', '');

        $fieldGroup->setActive(false);
        $this->assertEquals(false, $fieldGroup->getActive());

        $fieldGroup->setActive(true);
        $this->assertEquals(true, $fieldGroup->getActive());

    }

    public function testSetDescription()
    {

        $description = 'A description dy9823dgod';

        $fieldGroup = new FieldGroup('', '');

        $fieldGroup->setDescription($description);

        $this->assertEquals($description, $fieldGroup->getDescription());

    }

    public function testSetInstructionPlacement()
    {

        // Its ok to send any value
        $instructionPlacement = 'banana';

        $fieldGroup = new FieldGroup('', '');

        $fieldGroup->setInstructionPlacement($instructionPlacement);

        $this->assertEquals($instructionPlacement, $fieldGroup->getInstructionPlacement());

    }

    public function testSetLabelPlacement()
    {

        // Its ok to send any value
        $labelPlacement = 'orange';

        $fieldGroup = new FieldGroup('', '');

        $fieldGroup->setLabelPlacement($labelPlacement);

        $this->assertEquals($labelPlacement, $fieldGroup->getLabelPlacement());

    }

    public function testSetMenuOrder()
    {

        // Its ok to send any value
        $menuOrder = 10;

        $fieldGroup = new FieldGroup('', '');

        $fieldGroup->setMenuOrder($menuOrder);

        $this->assertEquals($menuOrder, $fieldGroup->getMenuOrder());

    }

    public function testSetPosition()
    {

        // Its ok to send any value
        $position = 'pear';

        $fieldGroup = new FieldGroup('', '');

        $fieldGroup->setPosition($position);

        $this->assertEquals($position, $fieldGroup->getPosition());

    }

    public function testSetSetting()
    {

        // Its ok to send any value
        $settingName = 'pear';
        $settingValue = 'kiwi';

        $fieldGroup = new FieldGroup('', '');

        $fieldGroup->setSetting($settingName, $settingValue);

        $this->assertEquals($settingValue, $fieldGroup->getSetting($settingName));

    }

    public function testGetSettingDefaultValue()
    {

        $settingName = 'setting_name_d9dg';
        $defaultValue = 'default_value_jd98ydoh';

        $fieldGroup = new FieldGroup('', '');

        $this->assertEquals($defaultValue, $fieldGroup->getSetting($settingName, $defaultValue));

    }

    public function testGetSettings()
    {

        $settings = [
            'setting_name_1' => 'setting_value_1',
            'setting_name_2' => 'setting_value_2',
        ];

        $fieldGroup = new FieldGroup('', '');

        $fieldGroup->setSetting('setting_name_1', $settings['setting_name_1']);
        $fieldGroup->setSetting('setting_name_2', $settings['setting_name_2']);

        $this->assertEquals($settings, $fieldGroup->getSettings());

    }

    public function testSetStyle()
    {

        // Its ok to send any value
        $style = 'dover_calais';

        $fieldGroup = new FieldGroup('', '');

        $fieldGroup->setStyle($style);

        $this->assertEquals($style, $fieldGroup->getStyle());

    }

    public function testSetFieldLabelPrefix()
    {

        $labelPrefix = 'A prefix dg78iku-';

        $fieldGroup = new FieldGroup('', '');

        $fieldGroup->addField(new Text('Text field', 'text_field', '1812132221a'));
        $fieldGroup->addField(new Text('Text field 2', 'text_field_2', '1812132221b'));

        $fieldGroup->setFieldLabelsPrefix($labelPrefix);

        $this->assertArraySubset(
            [
                [
                    'label' => $labelPrefix . 'Text field',
                ],
                [
                    'label' => $labelPrefix . 'Text field 2',
                ]
            ],
            $fieldGroup->toAcfArray()['fields']
        );

    }

    public function testSetFieldLabelSuffix()
    {

        $labelSuffix = '-A suffix g78fi';

        $fieldGroup = new FieldGroup('', '');

        $fieldGroup->addField(new Text('Text field', 'text_field', '1812132221a'));
        $fieldGroup->addField(new Text('Text field 2', 'text_field_2', '1812132221b'));

        $fieldGroup->setFieldLabelsSuffix($labelSuffix);

        $this->assertArraySubset(
            [
                [
                    'label' => 'Text field' . $labelSuffix,
                ],
                [
                    'label' => 'Text field 2' . $labelSuffix,
                ]
            ],
            $fieldGroup->toAcfArray()['fields']
        );

    }

    /**
     *
     */
    public function testRegister()
    {

        $fieldGroup = new FieldGroup('A field group', '1812132149a');

        $fieldGroup->addField(new Text('Text field 1', 'text_field_1', '1812132204a'));
        $fieldGroup->setDisplayInFewbricksDevTools(true);
        $fieldGroup->setSetting('setting_1_name', 'setting_1_value');
        $fieldGroup->setMenuOrder(78);
        $fieldGroup->setPosition('the_position_dgigk');
        $fieldGroup->setLabelPlacement('the_label_placement_y8yo');
        $fieldGroup->setDescription('Description d98sgl');
        $fieldGroup->setInstructionPlacement('Instruction placement dh8gol');
        $fieldGroup->setActive(false);
        $fieldGroup->setHideOnScreen('all');
        $fieldGroup->setShowOnScreen('slug');
        $fieldGroup->setStyle('dover_calais');
        $fieldGroup->setTitle('A new title dy8ohl');

        $this->assertEquals([
            'key' => 'group_1812132149a',
            'title' => 'A new title dy8ohl',
            'location' => [],
            'fewbricks__display_in_dev_tools' => true,
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
            $fieldGroup->register(false)->toAcfArray()
        );

    }

    public function testSetShowInFewbricksDevTools()
    {

        $fieldGroup = new FieldGroup('', '');

        $fieldGroup->setDisplayInFewbricksDevTools(true);

        $this->assertEquals(true, $fieldGroup->getDisplayInFewbricksDevTools());

    }


}
