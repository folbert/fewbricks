<?php
/**
 * Created by PhpStorm.
 * User: bjorn.folbert
 * Date: 2018-12-09
 * Time: 16:13
 */

namespace Fewbricks\Tests\ACF\Fields;

use Fewbricks\ACF\Fields\Textarea;
use Fewbricks\Tests\ACF\Field;
use Fewbricks\Tests\FieldHelper;

final class TextareaTest extends Field
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
            $field->toAcfArray($settings['test__key_prefix'])
        );

    }

    /**
     *
     */
    public function testSetAndGetMaxlength()
    {

        $field = new Textarea('', '', '');

        $this->assertEquals('', $field->getMaxlength());

        $field->setMaxlength(89);

        $this->assertEquals(89, $field->getMaxlength());

    }

    /**
     *
     */
    public function testSetAndGetNewLines()
    {

        $field = new Textarea('', '', '');

        $this->assertEquals('', $field->getNewLines());

        $field->setNewLines('wpautopjjlk');

        $this->assertEquals('wpautopjjlk', $field->getNewLines());

    }

    /**
     *
     */
    public function testSetAndGetPlaceholder()
    {

        $field = new Textarea('', '', '');

        $this->assertEquals('', $field->getPlaceholder());

        $field->setPlaceholder('sjohsishiho');

        $this->assertEquals('sjohsishiho', $field->getPlaceholder());

    }

    /**
     *
     */
    public function testSetAndGetRows()
    {

        $field = new Textarea('', '', '');

        $this->assertEquals('', $field->getRows());

        $field->setRows(10);

        $this->assertEquals(10, $field->getRows());

    }

}
