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
            $field->to_acf_array($settings['test__key_prefix'])
        );

    }

    /**
     *
     */
    public function testSetAndGetInsert()
    {

        $field = new Gallery('', '', '');

        $this->assertEquals('append', $field->get_insert());

        $field->set_insert('prepend');

        $this->assertEquals('prepend', $field->get_insert());

    }

    /**
     *
     */
    public function testSetAndGetMax()
    {

        $field = new Gallery('', '', '');

        $this->assertEquals(0, $field->get_max());

        $field->set_max(78);

        $this->assertEquals(78, $field->get_max());

    }

    /**
     *
     */
    public function testSetAndGetMaxHeight()
    {

        $field = new Gallery('', '', '');

        $this->assertEquals(0, $field->get_max_height());

        $field->set_max_height(78);

        $this->assertEquals(78, $field->get_max_height());

    }

    /**
     *
     */
    public function testSetAndGetMaxSize()
    {

        $field = new Gallery('', '', '');

        $this->assertEquals(0, $field->get_max_size());

        $field->set_max_size(78);

        $this->assertEquals(78, $field->get_max_size());

    }

    /**
     *
     */
    public function testSetAndGetMaxWidth()
    {

        $field = new Gallery('', '', '');

        $this->assertEquals(0, $field->get_max_width());

        $field->set_max_width(78);

        $this->assertEquals(78, $field->get_max_width());

    }

    /**
     *
     */
    public function testSetAndGetMin()
    {

        $field = new Gallery('', '', '');

        $this->assertEquals(0, $field->get_min());

        $field->set_min(78);

        $this->assertEquals(78, $field->get_min());

    }

    /**
     *
     */
    public function testSetAndGetMimeTypes()
    {

        $field = new Gallery('', '', '');

        $this->assertEquals('', $field->get_mime_types());

        $field->set_mime_types(['hggik', 'ohl/yuk']);

        $this->assertEquals('hggik, ohl/yuk', $field->get_mime_types());

        $field->set_mime_types('hggik, jdiohdo/g');

        $this->assertEquals('hggik, jdiohdo/g', $field->get_mime_types());

    }

    /**
     *
     */
    public function testSetAndGetMinHeight()
    {

        $field = new Gallery('', '', '');

        $this->assertEquals(0, $field->get_min_height());

        $field->set_min_height(78);

        $this->assertEquals(78, $field->get_min_height());

    }

    /**
     *
     */
    public function testSetAndGetMinSize()
    {

        $field = new Gallery('', '', '');

        $this->assertEquals(0, $field->get_min_size());

        $field->set_min_size(78);

        $this->assertEquals(78, $field->get_min_size());

    }

    /**
     *
     */
    public function testSetAndGetMinWidth()
    {

        $field = new Gallery('', '', '');

        $this->assertEquals(0, $field->get_min_width());

        $field->set_min_width(78);

        $this->assertEquals(78, $field->get_min_width());

    }

}
