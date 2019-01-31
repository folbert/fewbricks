<?php
/**
 * Created by PhpStorm.
 * User: bjorn.folbert
 * Date: 2018-12-09
 * Time: 16:13
 */

namespace Fewbricks\Tests\ACF\Fields;

use Fewbricks\ACF\Fields\GoogleMap;
use Fewbricks\Tests\ACF\FieldTest;
use Fewbricks\Tests\FieldHelper;

final class GoogleMapTest extends FieldTest
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
            $field->to_acf_array($settings['test__key_prefix'])
        );

    }

    /**
     *
     */
    public function testSetAndGetCenterLat()
    {

        $field = new GoogleMap('', '', '');

        $this->assertEquals('', $field->get_center_lat());

        $field->set_center_lat('23.2767');

        $this->assertEquals('23.2767', $field->get_center_lat());

    }

    /**
     *
     */
    public function testSetAndGetCenterLng()
    {

        $field = new GoogleMap('', '', '');

        $this->assertEquals('', $field->get_center_lng());

        $field->set_center_lng('127.456');

        $this->assertEquals('127.456', $field->get_center_lng());

    }

    /**
     *
     */
    public function testSetAndGetHeight()
    {

        $field = new GoogleMap('', '', '');

        $this->assertEquals('', $field->get_height());

        $field->set_height('250');

        $this->assertEquals('250', $field->get_height());

    }

    /**
     *
     */
    public function testSetAndGetZoom()
    {

        $field = new GoogleMap('', '', '');

        $this->assertEquals('', $field->get_zoom());

        $field->set_zoom('3');

        $this->assertEquals('3', $field->get_zoom());

    }

}
