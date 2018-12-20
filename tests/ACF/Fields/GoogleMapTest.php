<?php
/**
 * Created by PhpStorm.
 * User: bjorn.folbert
 * Date: 2018-12-09
 * Time: 16:13
 */

namespace Fewbricks\Tests\ACF\Fields;

use Fewbricks\ACF\Fields\GoogleMap;
use Fewbricks\Tests\ACF\Field;
use Fewbricks\Tests\FieldHelper;

final class GoogleMapTest extends Field
{

    // Will be used when creating the field object for this test
    const CLASS_NAME = 'Fewbricks\ACF\Fields\GoogleMap';

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
    public function testSetAndGetCenterLat()
    {

        $field = new GoogleMap('', '', '');

        $this->assertEquals($field->getCenterLat(), '-37.81411');

        $field->setCenterLat('23.2767');

        $this->assertEquals($field->getCenterLat(), '23.2767');

    }

    /**
     *
     */
    public function testSetAndGetCenterLng()
    {

        $field = new GoogleMap('', '', '');

        $this->assertEquals($field->getCenterLng(), '144.96328');

        $field->setCenterLng('127.456');

        $this->assertEquals($field->getCenterLng(), '127.456');

    }

    /**
     *
     */
    public function testSetAndGetHeight()
    {

        $field = new GoogleMap('', '', '');

        $this->assertEquals($field->getHeight(), '400');

        $field->setHeight('250');

        $this->assertEquals($field->getHeight(), '250');

    }

    /**
     *
     */
    public function testSetAndGetZoom()
    {

        $field = new GoogleMap('', '', '');

        $this->assertEquals($field->getZoom(), '14');

        $field->setHeight('3');

        $this->assertEquals($field->getHeight(), '3');

    }

}
