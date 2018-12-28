<?php
/**
 * Created by PhpStorm.
 * User: bjorn.folbert
 * Date: 2018-12-09
 * Time: 16:13
 */

namespace Fewbricks\Tests\ACF\Fields;

use Fewbricks\ACF\Fields\Email;
use Fewbricks\Tests\ACF\FieldTest;
use Fewbricks\Tests\FieldHelper;

final class EmailTest extends FieldTest
{

    // Will be used when creating the field object for this test
    const CLASS_NAME = 'Fewbricks\ACF\Fields\Email';

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

    public function testSetAndGetAppend()
    {

        $field = new Email('', '', '');

        $this->assertEquals('', $field->getAppend());

        $field->setAppend('89goi');

        $this->assertEquals('89goi', $field->getAppend());

    }

    public function testSetAndGetDefaultValue()
    {

        $field = new Email('', '', '');

        $this->assertEquals('', $field->getDefaultValue());

        $field->setDefaultValue('dh98go');

        $this->assertEquals('dh98go', $field->getDefaultValue());

    }

    public function testSetAndGetPlaceholder()
    {

        $field = new Email('', '', '');

        $this->assertEquals('', $field->getPlaceholder());

        $field->setPlaceholder('t7tiu');

        $this->assertEquals('t7tiu', $field->getPlaceholder());

    }

    public function testSetAndGetPrepend()
    {

        $field = new Email('', '', '');

        $this->assertEquals('', $field->getPrepend());

        $field->setPrepend('dt78ti');

        $this->assertEquals('dt78ti', $field->getPrepend());

    }

}
