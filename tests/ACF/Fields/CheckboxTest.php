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
            $field->toAcfArray($settings['test__key_prefix'])
        );

    }

    /**
     *
     */
    public function testSetAndGetAllowCustom()
    {

        $field = new Checkbox('', '', '');

        $this->assertEquals(0, $field->getAllowCustom());

        $field->setAllowCustom(true);

        $this->assertEquals(true, $field->getAllowCustom());

    }

    /**
     *
     */
    public function testSetAndGetChoices()
    {

        $field = new Checkbox('', '', '');

        $this->assertEquals([], $field->getChoices());

        $field->setChoices(['duih', 'e89oh']);

        $this->assertEquals(['duih', 'e89oh'], $field->getChoices());

    }

    /**
     *
     */
    public function testSetAndGetDefaultValue()
    {

        $field = new Checkbox('', '', '');

        $this->assertEquals('', $field->getDefaultValue());

        $field->setDefaultValue('d89oi');

        $this->assertEquals('d89oi', $field->getDefaultValue());

    }

    /**
     *
     */
    public function testSetAndGetLayout()
    {

        $field = new Checkbox('', '', '');

        $this->assertEquals('vertical', $field->getLayout());

        $field->setLayout(true);

        $this->assertEquals(true, $field->getLayout());

    }

    /**
     *
     */
    public function testSetAndGetReturnFormat()
    {

        $field = new Checkbox('', '', '');

        $this->assertEquals('value', $field->getReturnFormat());

        $field->setReturnFormat('hd89goil');

        $this->assertEquals('hd89goil', $field->getReturnFormat());

    }

    /**
     *
     */
    public function testSetAndGetSaveCustom()
    {

        $field = new Checkbox('', '', '');

        $this->assertEquals(0, $field->getSaveCustom());

        $field->setSaveCustom(true);

        $this->assertEquals(true, $field->getSaveCustom());

    }

    /**
     *
     */
    public function testSetAndGetToggle()
    {

        $field = new Checkbox('', '', '');

        $this->assertEquals(0, $field->getToggle());

        $field->setToggle(true);

        $this->assertEquals(true, $field->getToggle());

    }

}
