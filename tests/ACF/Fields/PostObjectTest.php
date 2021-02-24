<?php
/**
 * Created by PhpStorm.
 * User: bjorn.folbert
 * Date: 2018-12-09
 * Time: 16:13
 */

namespace Fewbricks\Tests\ACF\Fields;

use Fewbricks\ACF\Fields\PostObject;
use Fewbricks\Tests\ACF\FieldTest;
use Fewbricks\Tests\FieldHelper;

final class PostObjectTest extends FieldTest
{

    // Will be used when creating the field object for this test
    const CLASS_NAME = 'Fewbricks\ACF\Fields\PostObject';

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
    public function testSetAndGetAllowNull()
    {

        $field = new PostObject('', '', '');

        $this->assertEquals(0, $field->get_allow_null());

        $field->set_allow_null(true);

        $this->assertEquals(true, $field->get_allow_null());

    }

    /**
     *
     */
    public function testSetAndGetMultiple()
    {

        $field = new PostObject('', '', '');

        $this->assertEquals(0, $field->get_multiple());

        $field->set_multiple(true);

        $this->assertEquals(true, $field->get_multiple());

    }

    /**
     *
     */
    public function testSetAndGetPostType()
    {

        $field = new PostObject('', '', '');

        $this->assertEquals([], $field->get_post_type());

        $field->set_post_type(['page', 'custom']);

        $this->assertEquals(['page', 'custom'], $field->get_post_type());

    }

    /**
     *
     */
    public function testSetAndGetReturnFormat()
    {

        $field = new PostObject('', '', '');

        $this->assertEquals('object', $field->get_return_format());

        $field->set_return_format('array');

        $this->assertEquals('array', $field->get_return_format());

    }

    /**
     *
     */
    public function testSetAndGetTaxonomy()
    {

        $field = new PostObject('', '', '');

        $this->assertEquals([], $field->get_taxonomy());

        $field->set_taxonomy(['categories', 'custom']);

        $this->assertEquals(['categories', 'custom'], $field->get_taxonomy());

    }

}
