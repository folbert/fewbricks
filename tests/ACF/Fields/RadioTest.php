<?php
/**
 * Created by PhpStorm.
 * User: bjorn.folbert
 * Date: 2018-12-09
 * Time: 16:13
 */

namespace Fewbricks\Tests\ACF\Fields;

use Fewbricks\ACF\Fields\Radio;
use Fewbricks\Tests\ACF\FieldTest;
use Fewbricks\Tests\FieldHelper;

final class RadioTest extends FieldTest
{

    // Will be used when creating the field object for this test
    const CLASS_NAME = 'Fewbricks\ACF\Fields\Radio';

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

        $field = new Radio('', '', '');

        $this->assertEquals(0, $field->get_allow_null());

        $field->set_allow_null(true);

        $this->assertEquals(true, $field->get_allow_null());

    }

    public function testSetAndGetChoices()
    {

        $field = new Radio('', '', '');

        $this->assertEquals([], $field->getChoices());

        $field->set_choices(['adhiu', '98goi']);

        $this->assertEquals(['adhiu', '98goi'], $field->getChoices());

    }

    public function testSetAndGetDefaultValue()
    {

        $field = new Radio('', '', '');

        $this->assertEquals('', $field->get_default_value());

        $field->set_default_value('djhohsi');

        $this->assertEquals('djhohsi', $field->get_default_value());

    }

    public function testSetAndGetLayout()
    {

        $field = new Radio('', '', '');

        $this->assertEquals('vertical', $field->get_layout());

        $field->set_layout('horizontal');

        $this->assertEquals('horizontal', $field->get_layout());

    }

    public function testSetAndGetOtherChoice()
    {

        $field = new Radio('', '', '');

        $this->assertEquals(0, $field->get_other_choice());

        $field->set_other_choice(true);

        $this->assertEquals(true, $field->get_other_choice());

    }

    public function testSetAndGetReturnFormat()
    {

        $field = new Radio('', '', '');

        $this->assertEquals('value', $field->get_return_format());

        $field->set_return_format('dhiukl');

        $this->assertEquals('dhiukl', $field->get_return_format());

    }

    public function testSetAndGetSaveOtherChoice()
    {

        $field = new Radio('', '', '');

        $this->assertEquals(0, $field->get_save_other_choice());

        $field->set_save_other_choice(true);

        $this->assertEquals(true, $field->get_save_other_choice());

    }

}
