<?php
/**
 * Created by PhpStorm.
 * User: bjorn.folbert
 * Date: 2018-12-09
 * Time: 16:13
 */

namespace Fewbricks\Tests\ACF\Fields;

use Fewbricks\ACF\Fields\Repeater;
use Fewbricks\Tests\ACF\FieldTest;
use Fewbricks\Tests\FieldHelper;

final class RepeaterTest extends FieldTest
{

    // Will be used when creating the field object for this test
    const CLASS_NAME = 'Fewbricks\ACF\Fields\Repeater';

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

        $settings['sub_fields'] = [];

        $this->assertEquals(
            FieldHelper::getExpectedFieldValues($field, $settings),
            $field->toAcfArray($settings['test__key_prefix'])
        );

    }

    /**
     *
     */
    public function testSetAndGetButtonLabel()
    {

        $field = new Repeater('', '', '');

        $this->assertEquals('', $field->getButtonLabel());

        $field->setButtonLabel('Press the button');

        $this->assertEquals('Press the button', $field->getButtonLabel());

    }

    /**
     *
     */
    public function testSetAndGetCollapsed()
    {

        $field = new Repeater('', '', '');

        $this->assertEquals('', $field->getCollapsed());

        $field->setCollapsed('dg98gol');

        $this->assertEquals('dg98gol', $field->getCollapsed());

    }

    /**
     *
     */
    public function testSetAndGetLayout()
    {

        $field = new Repeater('', '', '');

        $this->assertEquals('table', $field->getLayout());

        $field->setLayout('row');

        $this->assertEquals('row', $field->getLayout());

    }

    /**
     *
     */
    public function testSetAndGetMax()
    {

        $field = new Repeater('', '', '');

        $this->assertEquals(0, $field->getMax());

        $field->setMax(45);

        $this->assertEquals(45, $field->getMax());

    }

    /**
     *
     */
    public function testSetAndGetMin()
    {

        $field = new Repeater('', '', '');

        $this->assertEquals(0, $field->getMin());

        $field->setMin(67);

        $this->assertEquals(67, $field->getMin());

    }

}
