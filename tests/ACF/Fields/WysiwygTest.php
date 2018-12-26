<?php
/**
 * Created by PhpStorm.
 * User: bjorn.folbert
 * Date: 2018-12-09
 * Time: 16:13
 */

namespace Fewbricks\Tests\ACF\Fields;

use Fewbricks\ACF\Fields\Wysiwyg;
use Fewbricks\Tests\ACF\Field;
use Fewbricks\Tests\FieldHelper;

final class WysiwygTest extends Field
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
            $field->toAcfArray($settings['test__key_prefix'])
        );

    }

    /**
     *
     */
    public function testSetAndGetDelay()
    {

        $field = new Wysiwyg('', '', '');

        $this->assertEquals(false, $field->getDelay());

        $field->setDelay(true);

        $this->assertEquals(true, $field->getDelay());

    }

    /**
     *
     */
    public function testSetAndGetMediaUpload()
    {

        $field = new Wysiwyg('', '', '');

        $this->assertEquals(true, $field->getMediaUpload());

        $field->setDelay(false);

        $this->assertEquals(true, $field->getMediaUpload());

    }

    /**
     *
     */
    public function testSetAndGetTabs()
    {

        $field = new Wysiwyg('', '', '');

        $this->assertEquals('all', $field->getTabs());

        $field->setTabs('visualdh89ogl');

        $this->assertEquals('visualdh89ogl', $field->getTabs());

    }

    /**
     *
     */
    public function testSetAndGetToolbar()
    {

        $field = new Wysiwyg('', '', '');

        $this->assertEquals('full', $field->getToolbar());

        $field->setToolbar('r87sfi');

        $this->assertEquals('r87sfi', $field->getToolbar());

    }


}
