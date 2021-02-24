<?php
/**
 * Created by PhpStorm.
 * User: bjorn.folbert
 * Date: 2018-12-09
 * Time: 16:13
 */

namespace Fewbricks\Tests\ACF\Fields;

use Fewbricks\ACF\Fields\ButtonGroup;
use Fewbricks\Tests\ACF\FieldTest;
use Fewbricks\Tests\FieldHelper;

final class ButtonGroupTest extends FieldTest
{

    // Will be used when creating the field object for this test
    const CLASS_NAME = 'Fewbricks\ACF\Fields\ButtonGroup';

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

        $this->assertEquals(
            FieldHelper::getExpectedFieldValues($field, $settings),
            $field->to_acf_array($settings['test__key_prefix'])
        );

    }

    public function testSetAndGetAllowNull()
    {

        $field = new ButtonGroup('', '', '');

        $this->assertEquals(0, $field->get_allow_null());

        $field->set_allow_null(true);

        $this->assertEquals(true, $field->get_allow_null());

    }

    public function testSetAndGetChoices()
    {

        $field = new ButtonGroup('', '', '');

        $this->assertEquals([], $field->get_choices());

        $choices = [
            'a' => 'An a',
            'b' => 'A B',
        ];

        $field->set_choices($choices);

        $this->assertEquals($choices, $field->get_choices());

    }

    public function testSetAndGetDefaultValue()
    {

        $field = new ButtonGroup('', '', '');

        $this->assertEquals('', $field->get_default_value());

        $field->set_default_value('dhoshooil');

        $this->assertEquals('dhoshooil', $field->get_default_value());

    }

    public function testSetAndGetLayout()
    {

        $field = new ButtonGroup('', '', '');

        $this->assertEquals('horizontal', $field->get_layout());

        $field->set_layout('ye8dgol');

        $this->assertEquals('ye8dgol', $field->get_layout());

    }

    public function testSetAndGetReturnFormat()
    {

        $field = new ButtonGroup('', '', '');

        $this->assertEquals('value', $field->get_return_format());

        $field->set_return_format('raw');

        $this->assertEquals('raw', $field->get_return_format());

    }

}
