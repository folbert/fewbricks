<?php
/**
 * Created by PhpStorm.
 * User: bjorn.folbert
 * Date: 2018-12-09
 * Time: 16:13
 */

namespace Fewbricks\Tests\ACF\Fields;

use Fewbricks\ACF\Fields\Gallery;
use Fewbricks\Tests\ACF\Field;
use Fewbricks\Tests\FieldHelper;

final class GalleryTest extends Field
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

        $this->assertEquals($field->getInsert(), 'append');

        $field->setInsert('prepend');

        $this->assertEquals($field->getInsert(), 'prepend');

    }

    /**
     *
     */
    public function testSetAndGetMax()
    {

        $field = new Gallery('', '', '');

        $this->assertEquals($field->getMax(), 0);

        $field->setMax(78);

        $this->assertEquals($field->getMax(), 78);

    }

    /**
     *
     */
    public function testSetAndGetMin()
    {

        $field = new Gallery('', '', '');

        $this->assertEquals($field->getMin(), 0);

        $field->setMin(78);

        $this->assertEquals($field->getMin(), 78);

    }

}
