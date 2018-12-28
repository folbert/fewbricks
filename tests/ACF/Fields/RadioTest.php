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
            $field->toAcfArray($settings['test__key_prefix'])
        );

    }

    public function testSetAndGetAllowNull()
    {

        $field = new Radio('', '', '');

        $this->assertEquals(0, $field->getAllowNull());

        $field->setAllowNull(true);

        $this->assertEquals(true, $field->getAllowNull());

    }

    public function testSetAndGetChoices()
    {

        $field = new Radio('', '', '');

        $this->assertEquals([], $field->getChoices());

        $field->setChoices(['adhiu', '98goi']);

        $this->assertEquals(['adhiu', '98goi'], $field->getChoices());

    }

    public function testSetAndGetDefaultValue()
    {

        $field = new Radio('', '', '');

        $this->assertEquals('', $field->getDefaultValue());

        $field->setDefaultValue('djhohsi');

        $this->assertEquals('djhohsi', $field->getDefaultValue());

    }

    public function testSetAndGetLayout()
    {

        $field = new Radio('', '', '');

        $this->assertEquals('vertical', $field->getLayout());

        $field->setLayout('horizontal');

        $this->assertEquals('horizontal', $field->getLayout());

    }

    public function testSetAndGetOtherChoice()
    {

        $field = new Radio('', '', '');

        $this->assertEquals(0, $field->getOtherChoice());

        $field->setOtherChoice(true);

        $this->assertEquals(true, $field->getOtherChoice());

    }

    public function testSetAndGetReturnFormat()
    {

        $field = new Radio('', '', '');

        $this->assertEquals('value', $field->getReturnFormat());

        $field->setReturnFormat('dhiukl');

        $this->assertEquals('dhiukl', $field->getReturnFormat());

    }

    public function testSetAndGetSaveOtherChoice()
    {

        $field = new Radio('', '', '');

        $this->assertEquals(0, $field->getSaveOtherChoice());

        $field->setSaveOtherChoice(true);

        $this->assertEquals(true, $field->getSaveOtherChoice());

    }

}
