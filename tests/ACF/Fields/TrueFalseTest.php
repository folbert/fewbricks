<?php
/**
 * Created by PhpStorm.
 * User: bjorn.folbert
 * Date: 2018-12-09
 * Time: 16:13
 */

namespace Fewbricks\Tests\ACF\Fields;

use Fewbricks\ACF\Fields\TrueFalse;
use Fewbricks\Tests\ACF\Field;
use Fewbricks\Tests\FieldHelper;

final class TrueFalseTest extends Field
{

    // Will be used when creating the field object for this test
    const CLASS_NAME = 'Fewbricks\ACF\Fields\TrueFalse';

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
    public function testSetAndGetDefaultValue()
    {

        $field = new TrueFalse('', '', '');

        $this->assertEquals('', $field->getDefaultValue());

        $field->setDefaultValue('dh08dhdol');

        $this->assertEquals('dh08dhdol', $field->getDefaultValue());

    }

    /**
     *
     */
    public function testSetAndGetUi()
    {

        $field = new TrueFalse('', '', '');

        $this->assertEquals(false, $field->getUi());

        $field->setUi(true);

        $this->assertEquals(true, $field->getUi());

    }

    /**
     *
     */
    public function testSetAndGetUiOffText()
    {

        $field = new TrueFalse('', '', '');

        $this->assertEquals('', $field->getUiOffText());

        $field->setUiOffText('fjoidjl');

        $this->assertEquals('fjoidjl', $field->getUiOffText());

    }

    /**
     *
     */
    public function testSetAndGetUiOnText()
    {

        $field = new TrueFalse('', '', '');

        $this->assertEquals('', $field->getUiOnText());

        $field->setUiOnText('8shsoil');

        $this->assertEquals('8shsoil', $field->getUiOnText());

    }

}
