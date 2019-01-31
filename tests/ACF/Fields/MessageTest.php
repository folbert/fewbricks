<?php
/**
 * Created by PhpStorm.
 * User: bjorn.folbert
 * Date: 2018-12-09
 * Time: 16:13
 */

namespace Fewbricks\Tests\ACF\Fields;

use Fewbricks\ACF\Fields\Message;
use Fewbricks\Tests\ACF\FieldTest;
use Fewbricks\Tests\FieldHelper;

final class MessageTest extends FieldTest
{

    // Will be used when creating the field object for this test
    const CLASS_NAME = 'Fewbricks\ACF\Fields\Message';

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
    public function testSetAndGetEscHtml()
    {

        $field = new Message('', '', '');

        $this->assertEquals(0, $field->get_esc_html());

        $field->set_esc_html(true);

        $this->assertEquals(true, $field->get_esc_html());

    }

    /**
     *
     */
    public function testSetAndGetMessage()
    {

        $field = new Message('', '', '');

        $this->assertEquals('', $field->get_message());

        $field->set_message('a message uiojio');

        $this->assertEquals('a message uiojio', $field->get_message());

    }

    /**
     *
     */
    public function testSetAndGetNewLines()
    {

        $field = new Message('', '', '');

        $this->assertEquals('wpautop', $field->get_new_lines());

        $field->set_new_lines('none');

        $this->assertEquals('none', $field->get_new_lines());

    }

}
