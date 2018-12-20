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

        $this->assertEquals('-37.81411', $field->getCenterLat());

        $field->setCenterLat('23.2767');

        $this->assertEquals('23.2767', $field->getCenterLat());

    }

    /**
     *
     */
    public function testSetAndGetCenterLng()
    {

        $field = new GoogleMap('', '', '');

        $this->assertEquals('144.96328', $field->getCenterLng());

        $field->setCenterLng('127.456');

        $this->assertEquals('127.456', $field->getCenterLng());

    }

    /**
     *
     */
    public function testSetAndGetHeight()
    {

        $field = new GoogleMap('', '', '');

        $this->assertEquals('400', $field->getHeight());

        $field->setHeight('250');

        $this->assertEquals('250', $field->getHeight());

    }

    /**
     *
     */
    public function testSetAndGetZoom()
    {

        $field = new GoogleMap('', '', '');

        $this->assertEquals('14', $field->getZoom());

        $field->setZoom('3');

        $this->assertEquals('3', $field->getZoom());

    }

}
