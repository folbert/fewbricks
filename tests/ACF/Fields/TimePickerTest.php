<?php
/**
 * Created by PhpStorm.
 * User: bjorn.folbert
 * Date: 2018-12-09
 * Time: 16:13
 */

namespace Fewbricks\Tests\ACF\Fields;

use Fewbricks\ACF\Fields\TimePicker;
use Fewbricks\Tests\ACF\FieldTest;
use Fewbricks\Tests\FieldHelper;

final class TimePickerTest extends FieldTest
{

    // Will be used when creating the field object for this test
    const CLASS_NAME = 'Fewbricks\ACF\Fields\TimePicker';

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
    public function testSetAndGetDisplayFormat()
    {

        $field = new TimePicker('', '', '');

        $this->assertEquals('g:i a', $field->get_display_format());

        $field->set_display_format('sy89xgol');

        $this->assertEquals('sy89xgol', $field->get_display_format());

    }

    /**
     *
     */
    public function testSetAndGetReturnFormat()
    {

        $field = new TimePicker('', '', '');

        $this->assertEquals('g:i a', $field->get_return_format());

        $field->set_return_format('sy89xgol');

        $this->assertEquals('sy89xgol', $field->get_return_format());

    }

}
