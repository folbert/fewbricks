<?php
/**
 * Created by PhpStorm.
 * User: bjorn.folbert
 * Date: 2018-12-09
 * Time: 16:13
 */

namespace Fewbricks\Tests\ACF\Fields;

use Fewbricks\ACF\Fields\Gallery;
use Fewbricks\Tests\ACF\FieldTest;
use Fewbricks\Tests\FieldHelper;

final class GalleryTest extends FieldTest
{

    // Will be used when creating the field object for this test
    const CLASS_NAME = 'Fewbricks\ACF\Fields\Gallery';

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
    public function testSetAndGetInsert()
    {

        $field = new Gallery('', '', '');

        $this->assertEquals('append', $field->getInsert());

        $field->setInsert('prepend');

        $this->assertEquals('prepend', $field->getInsert());

    }

    /**
     *
     */
    public function testSetAndGetMax()
    {

        $field = new Gallery('', '', '');

        $this->assertEquals(0, $field->getMax());

        $field->setMax(78);

        $this->assertEquals(78, $field->getMax());

    }

    /**
     *
     */
    public function testSetAndGetMaxHeight()
    {

        $field = new Gallery('', '', '');

        $this->assertEquals(0, $field->getMaxHeight());

        $field->setMaxHeight(78);

        $this->assertEquals(78, $field->getMaxHeight());

    }

    /**
     *
     */
    public function testSetAndGetMaxSize()
    {

        $field = new Gallery('', '', '');

        $this->assertEquals(0, $field->getMaxSize());

        $field->setMaxSize(78);

        $this->assertEquals(78, $field->getMaxSize());

    }

    /**
     *
     */
    public function testSetAndGetMaxWidth()
    {

        $field = new Gallery('', '', '');

        $this->assertEquals(0, $field->getMaxWidth());

        $field->setMaxWidth(78);

        $this->assertEquals(78, $field->getMaxWidth());

    }

    /**
     *
     */
    public function testSetAndGetMin()
    {

        $field = new Gallery('', '', '');

        $this->assertEquals(0, $field->getMin());

        $field->setMin(78);

        $this->assertEquals(78, $field->getMin());

    }

    /**
     *
     */
    public function testSetAndGetMimeTypes()
    {

        $field = new Gallery('', '', '');

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

        $field = new Gallery('', '', '');

        $this->assertEquals(0, $field->getMinHeight());

        $field->setMinHeight(78);

        $this->assertEquals(78, $field->getMinHeight());

    }

    /**
     *
     */
    public function testSetAndGetMinSize()
    {

        $field = new Gallery('', '', '');

        $this->assertEquals(0, $field->getMinSize());

        $field->setMinSize(78);

        $this->assertEquals(78, $field->getMinSize());

    }

    /**
     *
     */
    public function testSetAndGetMinWidth()
    {

        $field = new Gallery('', '', '');

        $this->assertEquals(0, $field->getMinWidth());

        $field->setMinWidth(78);

        $this->assertEquals(78, $field->getMinWidth());

    }

}
