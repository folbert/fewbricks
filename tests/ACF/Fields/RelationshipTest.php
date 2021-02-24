<?php
/**
 * Created by PhpStorm.
 * User: bjorn.folbert
 * Date: 2018-12-09
 * Time: 16:13
 */

namespace Fewbricks\Tests\ACF\Fields;

use Fewbricks\ACF\Fields\Relationship;
use Fewbricks\Tests\ACF\FieldTest;
use Fewbricks\Tests\FieldHelper;

final class RelationshipTest extends FieldTest
{

    // Will be used when creating the field object for this test
    const CLASS_NAME = 'Fewbricks\ACF\Fields\Relationship';

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
    public function testSetAndGetElements()
    {

        $field = new Relationship('', '', '');

        $this->assertEquals([], $field->get_elements());

        $field->set_elements(['one', '98gl']);

        $this->assertEquals(['one', '98gl'], $field->get_elements());

    }

    /**
     *
     */
    public function testSetAndGetFilters()
    {

        $field = new Relationship('', '', '');

        $this->assertEquals(['search', 'post_type', 'taxonomy'], $field->get_filters());

        $field->set_filters(['f23d', '98gl']);

        $this->assertEquals(['f23d', '98gl'], $field->get_filters());

    }

    /**
     *
     */
    public function testSetAndGetMax()
    {

        $field = new Relationship('', '', '');

        $this->assertEquals(0, $field->get_max());

        $field->set_max(65);

        $this->assertEquals(65, $field->get_max());

    }

    /**
     *
     */
    public function testSetAndGetMin()
    {

        $field = new Relationship('', '', '');

        $this->assertEquals(0, $field->get_min());

        $field->set_min(54);

        $this->assertEquals(54, $field->get_min());

    }

    /**
     *
     */
    public function testSetAndGetPostType()
    {

        $field = new Relationship('', '', '');

        $this->assertEquals([], $field->get_post_type());

        $field->set_post_type(['fdd3q23d', '98gl']);

        $this->assertEquals(['fdd3q23d', '98gl'], $field->get_post_type());

    }

    /**
     *
     */
    public function testSetAndGetReturnFormat()
    {

        $field = new Relationship('', '', '');

        $this->assertEquals('object', $field->get_return_format());

        $field->set_return_format('array');

        $this->assertEquals('array', $field->get_return_format());

    }

    /**
     *
     */
    public function testSetAndGetTaxonomy()
    {

        $field = new Relationship('', '', '');

        $this->assertEquals([], $field->get_taxonomy());

        $field->set_taxonomy(['custom1', 'custom2']);

        $this->assertEquals(['custom1', 'custom2'], $field->get_taxonomy());

    }

}
