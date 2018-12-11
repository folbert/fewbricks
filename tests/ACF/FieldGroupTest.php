<?php
/**
 * Created by PhpStorm.
 * User: bjorn.folbert
 * Date: 2018-12-09
 * Time: 16:13
 */

namespace Fewbricks\Tests\ACF;

use Fewbricks\ACF\FieldGroup;
use Fewbricks\ACF\FieldGroupLocationRule;
use Fewbricks\ACF\FieldGroupLocationRuleGroup;
use Fewbricks\ACF\Fields\Image;
use Fewbricks\ACF\Fields\Text;
use Fewbricks\Exceptions\DuplicateKeyException;
use Fewbricks\Tests\ImageAndTextBrick;
use FewbricksDemo\Bricks\ImageAndText;
use PHPUnit\Framework\TestCase;

final class FieldGroupTest extends TestCase
{

    private const CLASS_NAME = 'Fewbricks\ACF\FieldGroup';

    /**
     *
     */
    public function testClassExists()
    {
        $this->assertTrue(class_exists(self::CLASS_NAME));
    }

    /**
     *
     */
    public function testBaseSettings()
    {

        $title = 'A test field group';
        $key = '1812110742a';

        $fieldGroup = new FieldGroup($title, $key);

        $acfArray = $fieldGroup->toAcfArray();
        // Remove indexes that are outside the scope of this test
        unset($acfArray['fields']);

        $this->assertEquals([
            'title' => $title,
            'key' => 'group_' . $key,
            'location' => [],
        ],
            $acfArray
        );

    }

    /**
     *
     */
    public function testLocation()
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
            (new ImageAndTextBrick('image_n_text', '1812112239a'))
        );

        $fieldGroup->addBrick(
            new ImageAndTextBrick('brick_to_be_removed_by_name', '1812112247a')
        );

        $fieldGroup->addBrick(
            new ImageAndTextBrick('to_be_kept', '1812112248a')
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
                    'key' => 'field_1812112152b_1812112239a_1812112246a',
                    'label' => 'A textarea',
                    'name' => 'image_n_text_my_textarea',
                    'fewbricks__original_key' => '1812112246a',
                    'fewbricks__parents' => [
                        [
                            'key' => '1812112239a',
                            'name' => 'image_n_text',
                            'type' => 'brick',
                        ]
                    ],
                    'type' => 'textarea',
                ],
                [
                    'key' => 'field_1812112152b_1812112239a_1811122246a',
                    'label' => 'The URL',
                    'name' => 'image_n_text_my_url',
                    'fewbricks__original_key' => '1811122246a',
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
                    'key' => 'field_1812112152b_1812112248a_1812112246a',
                    'label' => 'A textarea',
                    'name' => 'to_be_kept_my_textarea',
                    'fewbricks__original_key' => '1812112246a',
                    'fewbricks__parents' => [
                        [
                            'key' => '1812112248a',
                            'name' => 'to_be_kept',
                            'type' => 'brick',
                        ]
                    ],
                    'type' => 'textarea',
                ],
                [
                    'key' => 'field_1812112152b_1812112248a_1811122246a',
                    'label' => 'The URL',
                    'name' => 'to_be_kept_my_url',
                    'fewbricks__original_key' => '1811122246a',
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
            (new ImageAndTextBrick('image_n_text', '1812112239a'))
        );

        $fieldGroup->addBrick(
            new ImageAndTextBrick('to_be_removed_by_key', '1812112247b')
        );

        $fieldGroup->addBrick(
            new ImageAndTextBrick('to_be_kept', '1812112248a')
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
                    'key' => 'field_1812112152b_1812112239a_1812112246a',
                    'label' => 'A textarea',
                    'name' => 'image_n_text_my_textarea',
                    'fewbricks__original_key' => '1812112246a',
                    'fewbricks__parents' => [
                        [
                            'key' => '1812112239a',
                            'name' => 'image_n_text',
                            'type' => 'brick',
                        ]
                    ],
                    'type' => 'textarea',
                ],
                [
                    'key' => 'field_1812112152b_1812112239a_1811122246a',
                    'label' => 'The URL',
                    'name' => 'image_n_text_my_url',
                    'fewbricks__original_key' => '1811122246a',
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
                    'key' => 'field_1812112152b_1812112248a_1812112246a',
                    'label' => 'A textarea',
                    'name' => 'to_be_kept_my_textarea',
                    'fewbricks__original_key' => '1812112246a',
                    'fewbricks__parents' => [
                        [
                            'key' => '1812112248a',
                            'name' => 'to_be_kept',
                            'type' => 'brick',
                        ]
                    ],
                    'type' => 'textarea',
                ],
                [
                    'key' => 'field_1812112152b_1812112248a_1811122246a',
                    'label' => 'The URL',
                    'name' => 'to_be_kept_my_url',
                    'fewbricks__original_key' => '1811122246a',
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

    public function testAddingBricks()
    {

        $fieldGroup = new FieldGroup('', '1812112150a');

        $fieldGroup->addField(
            (new Text('A textfield', 'a_textfield', '1812112152a'))
        );

        $fieldGroup->addBrick(
            (new ImageAndTextBrick('image_n_text', '1812112239a'))
        );

        $fieldGroup->addBrick(
            new ImageAndTextBrick('to_be_kept', '1812112248a')
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
                    'key' => 'field_1812112152b_1812112239a_1812112246a',
                    'label' => 'A textarea',
                    'name' => 'image_n_text_my_textarea',
                    'fewbricks__original_key' => '1812112246a',
                    'fewbricks__parents' => [
                        [
                            'key' => '1812112239a',
                            'name' => 'image_n_text',
                            'type' => 'brick',
                        ]
                    ],
                    'type' => 'textarea',
                ],
                [
                    'key' => 'field_1812112152b_1812112239a_1811122246a',
                    'label' => 'The URL',
                    'name' => 'image_n_text_my_url',
                    'fewbricks__original_key' => '1811122246a',
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
                    'key' => 'field_1812112152b_1812112248a_1812112246a',
                    'label' => 'A textarea',
                    'name' => 'to_be_kept_my_textarea',
                    'fewbricks__original_key' => '1812112246a',
                    'fewbricks__parents' => [
                        [
                            'key' => '1812112248a',
                            'name' => 'to_be_kept',
                            'type' => 'brick',
                        ]
                    ],
                    'type' => 'textarea',
                ],
                [
                    'key' => 'field_1812112152b_1812112248a_1811122246a',
                    'label' => 'The URL',
                    'name' => 'to_be_kept_my_url',
                    'fewbricks__original_key' => '1811122246a',
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
            new Text('Second text field', 'second_text_field', '1812112259a')
        );

        $fieldGroup->addFieldBeforeFieldByName(
            new Text('First text field', 'first_text_field', '1812112259b'),
            'second_text_field'
        );

        $acfArray = $fieldGroup->toAcfArray();

        $this->assertEquals([
            [
                'key' => 'field_1812112259b',
                'label' => 'First text field',
                'name' => 'first_text_field',
                'fewbricks__original_key' => '1812112259b',
                'fewbricks__parents' => [],
                'type' => 'text',
            ],
            [
                'key' => 'field_1812112259a',
                'label' => 'Second text field',
                'name' => 'second_text_field',
                'fewbricks__original_key' => '1812112259a',
                'fewbricks__parents' => [],
                'type' => 'text',
            ],
        ], $acfArray['fields']);

    }

    public function testInsertAfterFieldByName()
    {

        $fieldGroup = new FieldGroup('', '');

        $fieldGroup->addField(
            new Text('First text field', 'first_text_field', '1812112259a')
        );

        $fieldGroup->addField(
            new Text('Third text field', 'third_text_field', '1812112259b')
        );

        $fieldGroup->addFieldAfterFieldByName(
            new Text('Second text field', 'second_text_field', '1812112259c'),
            'first_text_field'
        );

        $acfArray = $fieldGroup->toAcfArray();

        $this->assertEquals([
            [
                'key' => 'field_1812112259a',
                'label' => 'First text field',
                'name' => 'first_text_field',
                'fewbricks__original_key' => '1812112259a',
                'fewbricks__parents' => [],
                'type' => 'text',
            ],
            [
                'key' => 'field_1812112259c',
                'label' => 'Second text field',
                'name' => 'second_text_field',
                'fewbricks__original_key' => '1812112259c',
                'fewbricks__parents' => [],
                'type' => 'text',
            ],
            [
                'key' => 'field_1812112259b',
                'label' => 'Third text field',
                'name' => 'third_text_field',
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

}
