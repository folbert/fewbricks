<?php
/**
 * Created by PhpStorm.
 * User: bjorn.folbert
 * Date: 2018-12-09
 * Time: 16:13
 */

namespace Fewbricks\Tests\ACF\Fields;

use Fewbricks\ACF\Fields\Number;
use Fewbricks\Tests\ACF\Field;
use Fewbricks\Tests\FieldHelper;

final class NumberTest extends Field
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
            $field->toAcfArray($settings['test__key_prefix'])
        );

    }

    /**
     *
     */
    public function testSetAndGetAppend()
    {

        $field = new Number('', '', '');

        $this->assertEquals($field->getAppend(), '');

        $field->setAppend('append kj jlk');

        $this->assertEquals($field->getAppend(), 'append kj jlk');

    }

    /**
     *
     */
    public function testSetAndGetMaximumValue()
    {

        $field = new Number('', '', '');

        $this->assertEquals('', $field->getMax());

        $field->setMax('879');

        $this->assertEquals('879', $field->getMax());

    }

    /**
     *
     */
    public function testSetAndGetMinimumValue()
    {

        $field = new Number('', '', '');

        $this->assertEquals('', $field->getMin());

        $field->setMin('879');

        $this->assertEquals('879', $field->getMin());

    }

    /**
     *
     */
    public function testSetAndGetPlaceholder()
    {

        $field = new Number('', '', '');

        $this->assertEquals('', $field->getPlaceholder());

        $field->setPlaceholder('placeholder uiuio');

        $this->assertEquals('placeholder uiuio', $field->getPlaceholder());

    }

    /**
     *
     */
    public function testSetAndGetPrepend()
    {

        $field = new Number('', '', '');

        $this->assertEquals('', $field->getPrepend());

        $field->setPrepend('prepend 8oupo');

        $this->assertEquals('prepend 8oupo', $field->getPrepend());

    }

    /**
     *
     */
    public function testSetAndGetStep()
    {

        $field = new Number('', '', '');

        $this->assertEquals('', $field->getStep());

        $field->setStep(10);

        $this->assertEquals(10, $field->getStep());

    }

}
