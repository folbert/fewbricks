<?php
/**
 * Created by PhpStorm.
 * User: bjorn.folbert
 * Date: 2018-12-09
 * Time: 16:13
 */

namespace Fewbricks\Tests\ACF\Fields;

use Fewbricks\ACF\Fields\Checkbox;
use Fewbricks\Tests\ACF\Field;
use Fewbricks\Tests\FieldHelper;

final class CheckboxTest extends Field
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

        $this->assertEquals($field->getAllowCustom(), false);

        $field->setAllowCustom(true);

        $this->assertEquals($field->getAllowCustom(), true);

    }

    /**
     *
     */
    public function testSetAndGetSaveCustom()
    {

        $field = new Checkbox('', '', '');

        $this->assertEquals($field->getSaveCustom(), false);

        $field->setSaveCustom(true);

        $this->assertEquals($field->getSaveCustom(), true);

    }

    /**
     *
     */
    public function testSetAndGetToggle()
    {

        $field = new Checkbox('', '', '');

        $this->assertEquals($field->getToggle(), false);

        $field->setToggle(true);

        $this->assertEquals($field->getToggle(), true);

    }

}
