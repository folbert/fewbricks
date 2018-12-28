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
            $field->toAcfArray($settings['test__key_prefix'])
        );

    }

    /**
     *
     */
    public function testSetAndGetLibrary()
    {

        $field = new File('', '', '');

        $this->assertEquals('all', $field->getLibrary());

        $field->setLibrary('some_library');

        $this->assertEquals('some_library', $field->getLibrary());

    }

    /**
     *
     */
    public function testSetAndGetMaxSize()
    {

        $field = new File('', '', '');

        $this->assertEquals(0, $field->getMaxSize());

        $field->setMaxSize(100);

        $this->assertEquals(100, $field->getMaxSize());

    }

    /**
     *
     */
    public function testSetAndGetMimeTypes()
    {

        $field = new File('', '', '');

        $this->assertEquals('', $field->getMimeTypes());

        $field->setMimeTypes('apple, banana');

        $this->assertEquals('apple, banana', $field->getMimeTypes());

        $field->setMimeTypes(['orange', 'pear']);

        $this->assertEquals('orange, pear', $field->getMimeTypes());

    }

    /**
     *
     */
    public function testSetAndGetMinSize()
    {

        $field = new File('', '', '');

        $this->assertEquals(0, $field->getMinSize());

        $field->setMinSize(100);

        $this->assertEquals(100, $field->getMinSize());

    }

    /**
     *
     */
    public function testSetAndGetReturnFormat()
    {

        $field = new File('', '', '');

        $this->assertEquals('array', $field->getReturnFormat());

        $field->setReturnFormat('object');

        $this->assertEquals('object', $field->getReturnFormat());

    }

}
