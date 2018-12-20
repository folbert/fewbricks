<?php
/**
 * Created by PhpStorm.
 * User: bjorn.folbert
 * Date: 2018-12-09
 * Time: 16:13
 */

namespace Fewbricks\Tests\ACF\Fields;

use Fewbricks\ACF\Fields\ButtonGroup;
use Fewbricks\Tests\ACF\Field;
use Fewbricks\Tests\FieldHelper;

final class ButtonGroupTest extends Field
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
            $field->toAcfArray($settings['test__key_prefix'])
        );

    }

    public function testSetAndGetLayout()
    {

        $field = new ButtonGroup('', '', '');

        $this->assertEquals('horizontal', $field->getLayout());

        $field->setLayout('ye8dgol');

        $this->assertEquals('ye8dgol', $field->getLayout());

    }

    public function testSetAndGetAllowNull()
    {

        $field = new ButtonGroup('', '', '');

        $this->assertEquals(false, $field->getAllowNull());

        $field->setAllowNull(true);

        $this->assertEquals(true, $field->getAllowNull());

    }

    public function testSetAndGetChoices()
    {

        $field = new ButtonGroup('', '', '');

        $this->assertEquals([], $field->getChoices());

        $choices = [
            'a' => 'An a',
            'b' => 'A B',
        ];

        $field->setChoices($choices);

        $this->assertEquals($choices, $field->getChoices());

    }

    public function testSetAndGetReturnFormat()
    {

        $field = new ButtonGroup('', '', '');

        $this->assertEquals('value', $field->getReturnFormat());

        $field->setReturnFormat('raw');

        $this->assertEquals('raw', $field->getReturnFormat());

    }

}
