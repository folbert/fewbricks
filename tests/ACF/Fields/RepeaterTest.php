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
            $field->to_acf_array($settings['test__key_prefix'])
        );

    }

    /**
     *
     */
    public function testSetAndGetButtonLabel()
    {

        $field = new Repeater('', '', '');

        $this->assertEquals('', $field->get_button_label());

        $field->set_button_label('Press the button');

        $this->assertEquals('Press the button', $field->get_button_label());

    }

    /**
     *
     */
    public function testSetAndGetCollapsed()
    {

        $field = new Repeater('', '', '');

        $this->assertEquals('', $field->get_collapsed());

        $field->set_collapsed('dg98gol');

        $this->assertEquals('dg98gol', $field->get_collapsed());

    }

    /**
     *
     */
    public function testSetAndGetLayout()
    {

        $field = new Repeater('', '', '');

        $this->assertEquals('table', $field->get_layout());

        $field->set_layout('row');

        $this->assertEquals('row', $field->get_layout());

    }

    /**
     *
     */
    public function testSetAndGetMax()
    {

        $field = new Repeater('', '', '');

        $this->assertEquals(0, $field->get_max());

        $field->set_max(45);

        $this->assertEquals(45, $field->get_max());

    }

    /**
     *
     */
    public function testSetAndGetMin()
    {

        $field = new Repeater('', '', '');

        $this->assertEquals(0, $field->get_min());

        $field->set_min(67);

        $this->assertEquals(67, $field->get_min());

    }

}
