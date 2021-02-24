<?php
/**
 * Created by PhpStorm.
 * User: bjorn.folbert
 * Date: 2018-12-09
 * Time: 16:13
 */

namespace Fewbricks\Tests\ACF\Fields;

use Fewbricks\ACF\Fields\Textarea;
use Fewbricks\Tests\ACF\FieldTest;
use Fewbricks\Tests\FieldHelper;

final class TextareaTest extends FieldTest
{

    // Will be used when creating the field object for this test
    const CLASS_NAME = 'Fewbricks\ACF\Fields\Textarea';

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
    public function testSetAndGetDefaultValue()
    {

        $field = new Textarea('', '', '');

        $this->assertEquals('', $field->get_default_value());

        $field->set_default_value('h8oigil');

        $this->assertEquals('h8oigil', $field->get_default_value());

    }

    /**
     *
     */
    public function testSetAndGetMaxlength()
    {

        $field = new Textarea('', '', '');

        $this->assertEquals('', $field->get_maxlength());

        $field->set_maxlength(89);

        $this->assertEquals(89, $field->get_maxlength());

    }

    /**
     *
     */
    public function testSetAndGetNewLines()
    {

        $field = new Textarea('', '', '');

        $this->assertEquals('', $field->get_new_lines());

        $field->set_new_lines('wpautopjjlk');

        $this->assertEquals('wpautopjjlk', $field->get_new_lines());

    }

    /**
     *
     */
    public function testSetAndGetPlaceholder()
    {

        $field = new Textarea('', '', '');

        $this->assertEquals('', $field->get_placeholder());

        $field->set_placeholder('sjohsishiho');

        $this->assertEquals('sjohsishiho', $field->get_placeholder());

    }

    /**
     *
     */
    public function testSetAndGetRows()
    {

        $field = new Textarea('', '', '');

        $this->assertEquals('', $field->get_rows());

        $field->set_rows(10);

        $this->assertEquals(10, $field->get_rows());

    }

}
