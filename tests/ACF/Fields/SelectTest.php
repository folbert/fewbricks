<?php
/**
 * Created by PhpStorm.
 * User: bjorn.folbert
 * Date: 2018-12-09
 * Time: 16:13
 */

namespace Fewbricks\Tests\ACF\Fields;

use Fewbricks\ACF\Fields\Select;
use Fewbricks\Tests\ACF\FieldTest;
use Fewbricks\Tests\FieldHelper;

final class SelectTest extends FieldTest
{

    // Will be used when creating the field object for this test
    const CLASS_NAME = 'Fewbricks\ACF\Fields\Select';

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
            'label' => 'A select field',
            'name' => 'name_of_the_select_field_et87giu',
            'key' => '1812101016a',
            // Internal test data that wil be removed when creating expected value
            'test__key_prefix' => '1812101016b',
            // These wil be set using setters on the field object
            'required' => true,
            'default_value' => 'Roland Deschain',
            'choices' => [
                'one' => 'One',
                'two' => 'Two',
            ]
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
    public function testSetAndGetAjax()
    {

        $field = new Select('', '', '');

        $this->assertEquals(0, $field->get_ajax());

        $field->set_ajax(true);

        $this->assertEquals(true, $field->get_ajax());

    }

    /**
     *
     */
    public function testSetAndGetAllowNull()
    {

        $field = new Select('', '', '');

        $this->assertEquals(0, $field->get_allow_null());

        $field->set_allow_null(true);

        $this->assertEquals(true, $field->get_allow_null());

    }

    /**
     *
     */
    public function testSetAndGetChoices()
    {

        $field = new Select('', '', '');

        $this->assertEquals([], $field->getChoices());

        $field->set_choices(['sjoil', 'dgiuv']);

        $this->assertEquals(['sjoil', 'dgiuv'], $field->getChoices());

    }

    /**
     *
     */
    public function testSetAndGetDefaultValue()
    {

        $field = new Select('', '', '');

        $this->assertEquals('', $field->get_default_value());

        $field->set_default_value('hoihl');

        $this->assertEquals('hoihl', $field->get_default_value());

    }

    /**
     *
     */
    public function testSetAndGetMultiple()
    {

        $field = new Select('', '', '');

        $this->assertEquals(false, $field->get_multiple());

        $field->set_multiple(true);

        $this->assertEquals(true, $field->get_multiple());

    }

    /**
     *
     */
    public function testSetAndGetReturnFormat()
    {

        $field = new Select('', '', '');

        $this->assertEquals('value', $field->get_return_format());

        $field->set_return_format('h98goil');

        $this->assertEquals('h98goil', $field->get_return_format());

    }

    /**
     *
     */
    public function testSetAndGetUi()
    {

        $field = new Select('', '', '');

        $this->assertEquals(false, $field->get_ui());

        $field->set_ui(true);

        $this->assertEquals(true, $field->get_ui());

    }

}
