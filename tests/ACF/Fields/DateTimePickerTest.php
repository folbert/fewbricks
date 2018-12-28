<?php
/**
 * Created by PhpStorm.
 * User: bjorn.folbert
 * Date: 2018-12-09
 * Time: 16:13
 */

namespace Fewbricks\Tests\ACF\Fields;

use Fewbricks\ACF\Fields\DateTimePicker;
use Fewbricks\Tests\ACF\FieldTest;
use Fewbricks\Tests\FieldHelper;

final class DateTimePickerTest extends FieldTest
{

    // Will be used when creating the field object for this test
    const CLASS_NAME = 'Fewbricks\ACF\Fields\DateTimePicker';

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
            $field->toAcfArray($settings['test__key_prefix'])
        );

    }

    /**
     *
     */
    public function testSetAndGetDisplayFormat()
    {

        $field = new DateTimePicker('', '', '');

        $this->assertEquals('d/m/Y g:i a', $field->getDisplayFormat());

        $field->setDisplayFormat('loremdy98oi');

        $this->assertEquals('loremdy98oi', $field->getDisplayFormat());

    }

    /**
     *
     */
    public function testSetAndGetFirstDay()
    {

        $field = new DateTimePicker('', '', '');

        $this->assertEquals(1, $field->getFirstDay());

        $field->setFirstDay(2);

        $this->assertEquals(2, $field->getFirstDay());

    }

    /**
     *
     */
    public function testSetAndGetReturnFormat()
    {

        $field = new DateTimePicker('', '', '');

        $this->assertEquals('d/m/Y g:i a', $field->getReturnFormat());

        $field->setReturnFormat('dn8odhil');

        $this->assertEquals('dn8odhil', $field->getReturnFormat());

    }

}
