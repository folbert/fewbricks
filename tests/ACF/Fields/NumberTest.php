<?php
/**
 * Created by PhpStorm.
 * User: bjorn.folbert
 * Date: 2018-12-09
 * Time: 16:13
 */

namespace Fewbricks\Tests\ACF\Fields;

use Fewbricks\ACF\Fields\Number;
use Fewbricks\Tests\ACF\FieldTest;
use Fewbricks\Tests\FieldHelper;

final class NumberTest extends FieldTest
{

    // Will be used when creating the field object for this test
    const CLASS_NAME = 'Fewbricks\ACF\Fields\Number';

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
    public function testSetAndGetAppend()
    {

        $field = new Number('', '', '');

        $this->assertEquals('', $field->get_append());

        $field->set_append('append kj jlk');

        $this->assertEquals('append kj jlk', $field->get_append());

    }

    /**
     *
     */
    public function testSetAndGetDefaultValue()
    {

        $field = new Number('', '', '');

        $this->assertEquals('', $field->get_default_value());

        $field->set_default_value('h98goi');

        $this->assertEquals('h98goi', $field->get_default_value());

    }

    /**
     *
     */
    public function testSetAndGetMax()
    {

        $field = new Number('', '', '');

        $this->assertEquals('', $field->get_max());

        $field->set_max('879');

        $this->assertEquals('879', $field->get_max());

    }

    /**
     *
     */
    public function testSetAndGetMin()
    {

        $field = new Number('', '', '');

        $this->assertEquals('', $field->get_min());

        $field->set_min('879');

        $this->assertEquals('879', $field->get_min());

    }

    /**
     *
     */
    public function testSetAndGetPlaceholder()
    {

        $field = new Number('', '', '');

        $this->assertEquals('', $field->get_placeholder());

        $field->set_placeholder('placeholder uiuio');

        $this->assertEquals('placeholder uiuio', $field->get_placeholder());

    }

    /**
     *
     */
    public function testSetAndGetPrepend()
    {

        $field = new Number('', '', '');

        $this->assertEquals('', $field->get_prepend());

        $field->set_prepend('prepend 8oupo');

        $this->assertEquals('prepend 8oupo', $field->get_prepend());

    }

    /**
     *
     */
    public function testSetAndGetStep()
    {

        $field = new Number('', '', '');

        $this->assertEquals('', $field->get_step());

        $field->set_step(10);

        $this->assertEquals(10, $field->get_step());

    }

}
