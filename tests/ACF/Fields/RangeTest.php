<?php
/**
 * Created by PhpStorm.
 * User: bjorn.folbert
 * Date: 2018-12-09
 * Time: 16:13
 */

namespace Fewbricks\Tests\ACF\Fields;

use Fewbricks\ACF\Fields\Range;
use Fewbricks\Tests\ACF\Field;
use Fewbricks\Tests\FieldHelper;

final class RangeTest extends Field
{

    // Will be used when creating the field object for this test
    const CLASS_NAME = 'Fewbricks\ACF\Fields\Range';

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

        $field = new Range('', '', '');

        $this->assertEquals('', $field->getAppend());

        $field->setAppend('dhde0oh');

        $this->assertEquals('dhde0oh', $field->getAppend());

    }

    /**
     *
     */
    public function testSetAndGetMax()
    {

        $field = new Range('', '', '');

        $this->assertEquals('', $field->getMax());

        $field->setMax(10);

        $this->assertEquals(10, $field->getMax());

    }

    /**
     *
     */
    public function testSetAndGetMin()
    {

        $field = new Range('', '', '');

        $this->assertEquals('', $field->getMin());

        $field->setMin(79);

        $this->assertEquals(79, $field->getMin());

    }

    /**
     *
     */
    public function testSetAndGetPrepend()
    {

        $field = new Range('', '', '');

        $this->assertEquals('', $field->getPrepend());

        $field->setPrepend('d132d');

        $this->assertEquals('d132d', $field->getPrepend());

    }

    /**
     *
     */
    public function testSetAndGetStep()
    {

        $field = new Range('', '', '');

        $this->assertEquals('', $field->getStep());

        $field->setStep(67);

        $this->assertEquals(67, $field->getStep());

    }

}
