<?php
/**
 * Created by PhpStorm.
 * User: bjorn.folbert
 * Date: 2018-12-09
 * Time: 16:13
 */

namespace Fewbricks\Tests\ACF\Fields;

use Fewbricks\ACF\Fields\Checkbox;
use Fewbricks\Tests\ACF\FieldTest;
use Fewbricks\Tests\FieldHelper;

final class CheckboxTest extends FieldTest
{

    // Will be used when creating the field object for this test
    const CLASS_NAME = 'Fewbricks\ACF\Fields\Checkbox';

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
    public function testSetAndGetAllowCustom()
    {

        $field = new Checkbox('', '', '');

        $this->assertEquals(0, $field->get_allow_custom());

        $field->setAllowCustom(true);

        $this->assertEquals(true, $field->get_allow_custom());

    }

    /**
     *
     */
    public function testSetAndGetChoices()
    {

        $field = new Checkbox('', '', '');

        $this->assertEquals([], $field->getChoices());

        $field->set_choices(['duih', 'e89oh']);

        $this->assertEquals(['duih', 'e89oh'], $field->getChoices());

    }

    /**
     *
     */
    public function testSetAndGetDefaultValue()
    {

        $field = new Checkbox('', '', '');

        $this->assertEquals('', $field->get_default_value());

        $field->set_default_value('d89oi');

        $this->assertEquals('d89oi', $field->get_default_value());

    }

    /**
     *
     */
    public function testSetAndGetLayout()
    {

        $field = new Checkbox('', '', '');

        $this->assertEquals('vertical', $field->get_layout());

        $field->set_layout(true);

        $this->assertEquals(true, $field->get_layout());

    }

    /**
     *
     */
    public function testSetAndGetReturnFormat()
    {

        $field = new Checkbox('', '', '');

        $this->assertEquals('value', $field->get_return_format());

        $field->set_return_format('hd89goil');

        $this->assertEquals('hd89goil', $field->get_return_format());

    }

    /**
     *
     */
    public function testSetAndGetSaveCustom()
    {

        $field = new Checkbox('', '', '');

        $this->assertEquals(0, $field->get_save_custom());

        $field->set_save_custom(true);

        $this->assertEquals(true, $field->get_save_custom());

    }

    /**
     *
     */
    public function testSetAndGetToggle()
    {

        $field = new Checkbox('', '', '');

        $this->assertEquals(0, $field->get_toggle());

        $field->set_toggle(true);

        $this->assertEquals(true, $field->get_toggle());

    }

}
