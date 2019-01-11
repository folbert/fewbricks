<?php
/**
 * Created by PhpStorm.
 * User: bjorn.folbert
 * Date: 2018-12-09
 * Time: 16:13
 */

namespace Fewbricks\Tests\ACF\Fields;

use Fewbricks\ACF\Fields\Group;
use Fewbricks\ACF\Fields\Text;
use Fewbricks\Tests\ACF\FieldTest;
use Fewbricks\Tests\FieldHelper;
use Fewbricks\Tests\TextAndUrlBrick;

final class GroupTest extends FieldTest
{

    // Will be used when creating the field object for this test
    const CLASS_NAME = 'Fewbricks\ACF\Fields\Group';

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
    public function testAcfArray()
    {

        $settings = [
            // Used for creating the field object
            'label' => 'A field',
            'name' => 'name_of_the_field_et87giu',
            'key' => '1812101016a',
            // Internal test data that wil be removed when creating expected value
            'test__key_prefix' => '1812101016b',
            // These wil be set using setters on the field object
        ];

        $field = FieldHelper::getCompleteFieldObject(self::CLASS_NAME, $settings, $this);

        $settings['sub_fields'] = [];

        $this->assertEquals(
            FieldHelper::getExpectedFieldValues($field, $settings),
            $field->toAcfArray($settings['test__key_prefix'])
        );

    }

    /**
     *
     */
    public function testSetAndGetLayout()
    {

        $field = new Group('', '', '');

        $this->assertEquals('block', $field->getLayout());

        $field->setLayout('table');

        $this->assertEquals('table', $field->getLayout());

    }

    public function testAddBrick()
    {

        $field = new Group('Label t78i', 'name_89yo', 'key_98o');

        $brick1 = new TextAndUrlBrick('Image and text 1', 'brickkey_d7hl');
        $brick2 = new TextAndUrlBrick('Image and text 2', 'brickkey_hih6');

        $field->addBrick($brick1);
        $field->addBrick($brick2);

        $this->assertArraySubset([
            'sub_fields' => [
                [
                    'key' => 'field_key_98o_brickkey_d7hl_imageandtextbrickfield_text_key',
                    'fewbricks__parents' => [
                        [
                            'key' => 'brickkey_d7hl',
                            'name' => 'Image and text 1',
                            'type' => 'brick'
                        ],
                    ],
                ],
                [
                    'key' => 'field_key_98o_brickkey_d7hl_imageandtextbrickfield_url_key',
                    'fewbricks__parents' => [
                        [
                            'key' => 'brickkey_d7hl',
                            'name' => 'Image and text 1',
                            'type' => 'brick'
                        ],
                    ],
                ],
                [
                    'key' => 'field_key_98o_brickkey_hih6_imageandtextbrickfield_text_key',
                    'fewbricks__parents' => [
                        [
                            'key' => 'brickkey_hih6',
                            'name' => 'Image and text 2',
                            'type' => 'brick'
                        ],
                    ],
                ],
                [
                    'key' => 'field_key_98o_brickkey_hih6_imageandtextbrickfield_url_key',
                    'fewbricks__parents' => [
                        [
                            'key' => 'brickkey_hih6',
                            'name' => 'Image and text 2',
                            'type' => 'brick'
                        ],
                    ],
                ]
            ]
        ], $field->toAcfArray());

    }

    public function testAddBrickAfterFieldByName()
    {

        $field = new Group('Label t78i', 'name_89yo', 'key_98o');

        $brick1 = new TextAndUrlBrick('image_and_text_brick_1', 'brickkey_d7hl');
        $brick2 = new TextAndUrlBrick('image_and_text_brick_2', 'brickkey_hih6');

        $field->addBrick($brick1);
        $field->addBrick($brick2);

        $brick3 = new TextAndUrlBrick('image_and_text_brick_3', 'brickkey_dg4f');

        $field->addBrickAfterFieldByName($brick3, 'image_and_text_brick_1_my_text');

        $this->assertArraySubset([
            'sub_fields' => [
                [
                    'key' => 'field_key_98o_brickkey_d7hl_imageandtextbrickfield_text_key',
                    'fewbricks__parents' => [
                        [
                            'key' => 'brickkey_d7hl',
                            'name' => 'image_and_text_brick_1',
                            'type' => 'brick'
                        ],
                    ],
                ],
                [
                    'key' => 'field_key_98o_brickkey_dg4f_imageandtextbrickfield_text_key',
                    'fewbricks__parents' => [
                        [
                            'key' => 'brickkey_dg4f',
                            'name' => 'image_and_text_brick_3',
                            'type' => 'brick'
                        ],
                    ],
                ],
                [
                    'key' => 'field_key_98o_brickkey_dg4f_imageandtextbrickfield_url_key',
                    'fewbricks__parents' => [
                        [
                            'key' => 'brickkey_dg4f',
                            'name' => 'image_and_text_brick_3',
                            'type' => 'brick'
                        ],
                    ],
                ],
                [
                    'key' => 'field_key_98o_brickkey_d7hl_imageandtextbrickfield_url_key',
                    'fewbricks__parents' => [
                        [
                            'key' => 'brickkey_d7hl',
                            'name' => 'image_and_text_brick_1',
                            'type' => 'brick'
                        ],
                    ],
                ],
                [
                    'key' => 'field_key_98o_brickkey_hih6_imageandtextbrickfield_text_key',
                    'fewbricks__parents' => [
                        [
                            'key' => 'brickkey_hih6',
                            'name' => 'image_and_text_brick_2',
                            'type' => 'brick'
                        ],
                    ],
                ],
                [
                    'key' => 'field_key_98o_brickkey_hih6_imageandtextbrickfield_url_key',
                    'fewbricks__parents' => [
                        [
                            'key' => 'brickkey_hih6',
                            'name' => 'image_and_text_brick_2',
                            'type' => 'brick'
                        ],
                    ],
                ],
            ],
        ], $field->toAcfArray());

    }

    public function testAddBrickBeforeFieldByName()
    {

        $field = new Group('Label t78i', 'name_89yo', 'key_98o');

        $field->addField(new Text('A text1', 'a_text_1', '1812291546a'));
        $field->addField(new Text('A text2', 'a_text_2', '1812291546b'));

        $brick = new TextAndUrlBrick('image_and_text_brick_3', 'brickkey_dg4f');

        $field->addBrickBeforeFieldByName($brick, 'a_text_2');

        $this->assertArraySubset([
            'sub_fields' => [
                [
                    'key' => 'field_key_98o_1812291546a',
                ],
                [
                    'key' => 'field_key_98o_brickkey_dg4f_imageandtextbrickfield_text_key',
                    'fewbricks__parents' => [
                        [
                            'key' => 'brickkey_dg4f',
                            'name' => 'image_and_text_brick_3',
                            'type' => 'brick'
                        ],
                    ],
                ],
                [
                    'key' => 'field_key_98o_brickkey_dg4f_imageandtextbrickfield_url_key',
                    'fewbricks__parents' => [
                        [
                            'key' => 'brickkey_dg4f',
                            'name' => 'image_and_text_brick_3',
                            'type' => 'brick'
                        ],
                    ],
                ],
                [
                    'key' => 'field_key_98o_1812291546b',
                ],
            ],
        ], $field->toAcfArray());

    }

}
