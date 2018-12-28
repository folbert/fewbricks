<?php
/**
 * Created by PhpStorm.
 * User: bjorn.folbert
 * Date: 2018-12-09
 * Time: 16:13
 */

namespace Fewbricks\Tests\ACF\Fields;

use Fewbricks\ACF\Fields\Image;
use Fewbricks\Tests\ACF\FieldTest;
use Fewbricks\Tests\FieldHelper;

final class ImageTest extends FieldTest
{

    // Will be used when creating the field object for this test
    const CLASS_NAME = 'Fewbricks\ACF\Fields\Image';

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

        $field = new Image('', '', '');

        $this->assertEquals('all', $field->getLibrary());

        $field->setLibrary('hiho');

        $this->assertEquals('hiho', $field->getLibrary());

    }

    /**
     *
     */
    public function testSetAndGetMaxHeight()
    {

        $field = new Image('', '', '');

        $this->assertEquals(0, $field->getMaxHeight());

        $field->setMaxHeight(67);

        $this->assertEquals(67, $field->getMaxHeight());

    }

    /**
     *
     */
    public function testSetAndGetMaxSize()
    {

        $field = new Image('', '', '');

        $this->assertEquals(0, $field->getMaxSize());

        $field->setMaxSize(67);

        $this->assertEquals(67, $field->getMaxSize());

    }

    /**
     *
     */
    public function testSetAndGetMaxWidth()
    {

        $field = new Image('', '', '');

        $this->assertEquals(0, $field->getMaxWidth());

        $field->setMaxWidth(67);

        $this->assertEquals(67, $field->getMaxWidth());

    }

    /**
     *
     */
    public function testSetAndGetMimeTypes()
    {

        $field = new Image('', '', '');

        $this->assertEquals('', $field->getMimeTypes());

        $field->setMimeTypes(['hggik', 'ohl/yuk']);

        $this->assertEquals('hggik, ohl/yuk', $field->getMimeTypes());

        $field->setMimeTypes('hggik, jdiohdo/g');

        $this->assertEquals('hggik, jdiohdo/g', $field->getMimeTypes());

    }

    /**
     *
     */
    public function testSetAndGetMinHeight()
    {

        $field = new Image('', '', '');

        $this->assertEquals(0, $field->getMinHeight());

        $field->setMinHeight(67);

        $this->assertEquals(67, $field->getMinHeight());

    }

    /**
     *
     */
    public function testSetAndGetMinSize()
    {

        $field = new Image('', '', '');

        $this->assertEquals(0, $field->getMinSize());

        $field->setMinSize(67);

        $this->assertEquals(67, $field->getMinSize());

    }

    /**
     *
     */
    public function testSetAndGetMinWidth()
    {

        $field = new Image('', '', '');

        $this->assertEquals(0, $field->getMinWidth());

        $field->setMinWidth(67);

        $this->assertEquals(67, $field->getMinWidth());

    }

    /**
     *
     */
    public function testSetAndGetPreviewSize()
    {

        $field = new Image('', '', '');

        $this->assertEquals($field->getPreviewSize(), 'thumbnail');

        $field->setPreviewSize('full');

        $this->assertEquals($field->getPreviewSize(), 'full');

    }

    /**
     *
     */
    public function testSetAndGetReturnFormat()
    {

        $field = new Image('', '', '');

        $this->assertEquals('array', $field->getReturnFormat());

        $field->setReturnFormat('object');

        $this->assertEquals('object', $field->getReturnFormat());

    }

}
