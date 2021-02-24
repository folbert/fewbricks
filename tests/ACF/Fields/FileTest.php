<?php
/**
 * Created by PhpStorm.
 * User: bjorn.folbert
 * Date: 2018-12-09
 * Time: 16:13
 */

namespace Fewbricks\Tests\ACF\Fields;

use Fewbricks\ACF\Fields\File;
use Fewbricks\Tests\ACF\FieldTest;
use Fewbricks\Tests\FieldHelper;

final class FileTest extends FieldTest
{

    // Will be used when creating the field object for this test
    const CLASS_NAME = 'Fewbricks\ACF\Fields\File';

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
    public function testSetAndGetLibrary()
    {

        $field = new File('', '', '');

        $this->assertEquals('all', $field->get_library());

        $field->set_library('some_library');

        $this->assertEquals('some_library', $field->get_library());

    }

    /**
     *
     */
    public function testSetAndGetMaxSize()
    {

        $field = new File('', '', '');

        $this->assertEquals(0, $field->get_max_size());

        $field->set_max_size(100);

        $this->assertEquals(100, $field->get_max_size());

    }

    /**
     *
     */
    public function testSetAndGetMimeTypes()
    {

        $field = new File('', '', '');

        $this->assertEquals('', $field->get_mime_types());

        $field->set_mime_types('apple, banana');

        $this->assertEquals('apple, banana', $field->get_mime_types());

        $field->set_mime_types(['orange', 'pear']);

        $this->assertEquals('orange, pear', $field->get_mime_types());

    }

    /**
     *
     */
    public function testSetAndGetMinSize()
    {

        $field = new File('', '', '');

        $this->assertEquals(0, $field->get_min_size());

        $field->set_min_size(100);

        $this->assertEquals(100, $field->get_min_size());

    }

    /**
     *
     */
    public function testSetAndGetReturnFormat()
    {

        $field = new File('', '', '');

        $this->assertEquals('array', $field->get_return_format());

        $field->set_return_format('object');

        $this->assertEquals('object', $field->get_return_format());

    }

}
