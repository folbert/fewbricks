<?php
/**
 * Created by PhpStorm.
 * User: bjorn.folbert
 * Date: 2018-12-09
 * Time: 16:13
 */

namespace Fewbricks\Tests\ACF\Fields;

use Fewbricks\ACF\Fields\TrueFalse;
use Fewbricks\Tests\ACF\FieldTest;
use Fewbricks\Tests\FieldHelper;

final class TrueFalseTest extends FieldTest
{

    // Will be used when creating the field object for this test
    const CLASS_NAME = 'Fewbricks\ACF\Fields\TrueFalse';

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

    /**
     *
     */
    public function testSetAndGetDefaultValue()
    {

        $field = new TrueFalse('', '', '');

        $this->assertEquals(0, $field->get_default_value());

        $field->set_default_value('dh08dhdol');

        $this->assertEquals('dh08dhdol', $field->get_default_value());

    }

    /**
     *
     */
    public function testSetAndGetMessage()
    {

        $field = new TrueFalse('', '', '');

        $this->assertEquals('', $field->get_message());

        $field->set_message('hg78iu');

        $this->assertEquals('hg78iu', $field->get_message());

    }

    /**
     *
     */
    public function testSetAndGetUi()
    {

        $field = new TrueFalse('', '', '');

        $this->assertEquals(0, $field->get_ui());

        $field->set_ui(true);

        $this->assertEquals(true, $field->get_ui());

    }

    /**
     *
     */
    public function testSetAndGetUiOffText()
    {

        $field = new TrueFalse('', '', '');

        $this->assertEquals('', $field->get_ui_off_text());

        $field->set_ui_off_text('fjoidjl');

        $this->assertEquals('fjoidjl', $field->get_ui_off_text());

    }

    /**
     *
     */
    public function testSetAndGetUiOnText()
    {

        $field = new TrueFalse('', '', '');

        $this->assertEquals('', $field->get_ui_on_text());

        $field->set_ui_on_text('8shsoil');

        $this->assertEquals('8shsoil', $field->get_ui_on_text());

    }

}
