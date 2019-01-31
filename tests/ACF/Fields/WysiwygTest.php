<?php
/**
 * Created by PhpStorm.
 * User: bjorn.folbert
 * Date: 2018-12-09
 * Time: 16:13
 */

namespace Fewbricks\Tests\ACF\Fields;

use Fewbricks\ACF\Fields\Wysiwyg;
use Fewbricks\Tests\ACF\FieldTest;
use Fewbricks\Tests\FieldHelper;

final class WysiwygTest extends FieldTest
{

    // Will be used when creating the field object for this test
    const CLASS_NAME = 'Fewbricks\ACF\Fields\Wysiwyg';

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

        $field = new Wysiwyg('', '', '');

        $this->assertEquals('', $field->get_default_value());

        $field->set_default_value('dg8igol');

        $this->assertEquals('dg8igol', $field->get_default_value());

    }

    /**
     *
     */
    public function testSetAndGetDelay()
    {

        $field = new Wysiwyg('', '', '');

        $this->assertEquals(0, $field->get_delay());

        $field->set_delay(true);

        $this->assertEquals(true, $field->get_delay());

    }

    /**
     *
     */
    public function testSetAndGetMediaUpload()
    {

        $field = new Wysiwyg('', '', '');

        $this->assertEquals(1, $field->get_media_upload());

        $field->set_media_upload(false);

        $this->assertEquals(false, $field->get_media_upload());

    }

    /**
     *
     */
    public function testSetAndGetTabs()
    {

        $field = new Wysiwyg('', '', '');

        $this->assertEquals('all', $field->get_tabs());

        $field->set_tabs('visualdh89ogl');

        $this->assertEquals('visualdh89ogl', $field->get_tabs());

    }

    /**
     *
     */
    public function testSetAndGetToolbar()
    {

        $field = new Wysiwyg('', '', '');

        $this->assertEquals('full', $field->get_toolbar());

        $field->set_toolbar('r87sfi');

        $this->assertEquals('r87sfi', $field->get_toolbar());

    }

}
