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
            $field->to_acf_array($settings['test__key_prefix'])
        );

    }

    /**
     *
     */
    public function testSetAndGetLayout()
    {

        $field = new Group('', '', '');

        $this->assertEquals('block', $field->get_layout());

        $field->set_layout('table');

        $this->assertEquals('table', $field->get_layout());

    }

    public function testAddBrick()
    {

        $field = new Group('Label t78i', 'name_89yo', 'key_98o');

        $brick1 = new TextAndUrlBrick('brickkey_d7hl', 'image_and_text_1');
        $brick2 = new TextAndUrlBrick('brickkey_hih6', 'image_and_text_2');

        $field->add_brick($brick1);
        $field->add_brick($brick2);

        $this->assertArraySubset([
            'sub_fields' => [
                [
                    'key' => 'field_key_98o_brickkey_d7hl_imageandtextbrickfield_text_key',
                    'fewbricks__parents' => [
                        [
                            'key' => 'brickkey_d7hl',
                            'name' => 'image_and_text_1',
                            'type' => 'brick'
                        ],
                    ],
                ],
                [
                    'key' => 'field_key_98o_brickkey_d7hl_imageandtextbrickfield_url_key',
                    'fewbricks__parents' => [
                        [
                            'key' => 'brickkey_d7hl',
                            'name' => 'image_and_text_1',
                            'type' => 'brick'
                        ],
                    ],
                ],
                [
                    'key' => 'field_key_98o_brickkey_hih6_imageandtextbrickfield_text_key',
                    'fewbricks__parents' => [
                        [
                            'key' => 'brickkey_hih6',
                            'name' => 'image_and_text_2',
                            'type' => 'brick'
                        ],
                    ],
                ],
                [
                    'key' => 'field_key_98o_brickkey_hih6_imageandtextbrickfield_url_key',
                    'fewbricks__parents' => [
                        [
                            'key' => 'brickkey_hih6',
                            'name' => 'image_and_text_2',
                            'type' => 'brick'
                        ],
                    ],
                ]
            ]
        ], $field->to_acf_array());

    }

    public function testAddBrickAfterFieldByName()
    {

        $field = new Group('Label t78i', 'name_89yo', 'key_98o');

        $brick1 = new TextAndUrlBrick('brickkey_d7hl', 'image_and_text_brick_1');
        $brick2 = new TextAndUrlBrick('brickkey_hih6', 'image_and_text_brick_2');

        $field->add_brick($brick1);
        $field->add_brick($brick2);

        $brick3 = new TextAndUrlBrick('brickkey_dg4f', 'image_and_text_brick_3');

        $field->add_brick_after_field_by_name($brick3, 'image_and_text_brick_1_my_text');

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
        ], $field->to_acf_array());

    }

    public function testAddBrickBeforeFieldByName()
    {

        $field = new Group('Label t78i', 'name_89yo', 'key_98o');

        $field->add_field(new Text('A text1', 'a_text_1', '1812291546a'));
        $field->add_field(new Text('A text2', 'a_text_2', '1812291546b'));

        $brick = new TextAndUrlBrick('brickkey_dg4f', 'image_and_text_brick_3');

        $field->add_brick_before_field_by_name($brick, 'a_text_2');

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
        ], $field->to_acf_array());

    }

}
