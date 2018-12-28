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
            $field->toAcfArray($settings['test__key_prefix'])
        );

    }

    /**
     *
     */
    public function testSetAndGetElements()
    {

        $field = new Relationship('', '', '');

        $this->assertEquals([], $field->getElements());

        $field->setElements(['one', '98gl']);

        $this->assertEquals(['one', '98gl'], $field->getElements());

    }

    /**
     *
     */
    public function testSetAndGetFilters()
    {

        $field = new Relationship('', '', '');

        $this->assertEquals(['search', 'post_type', 'taxonomy'], $field->getFilters());

        $field->setFilters(['f23d', '98gl']);

        $this->assertEquals(['f23d', '98gl'], $field->getFilters());

    }

    /**
     *
     */
    public function testSetAndGetMax()
    {

        $field = new Relationship('', '', '');

        $this->assertEquals(0, $field->getMax());

        $field->setMax(65);

        $this->assertEquals(65, $field->getMax());

    }

    /**
     *
     */
    public function testSetAndGetMin()
    {

        $field = new Relationship('', '', '');

        $this->assertEquals(0, $field->getMin());

        $field->setMin(54);

        $this->assertEquals(54, $field->getMin());

    }

    /**
     *
     */
    public function testSetAndGetPostType()
    {

        $field = new Relationship('', '', '');

        $this->assertEquals([], $field->getPostType());

        $field->setPostType(['fdd3q23d', '98gl']);

        $this->assertEquals(['fdd3q23d', '98gl'], $field->getPostType());

    }

    /**
     *
     */
    public function testSetAndGetReturnFormat()
    {

        $field = new Relationship('', '', '');

        $this->assertEquals('object', $field->getReturnFormat());

        $field->setReturnFormat('array');

        $this->assertEquals('array', $field->getReturnFormat());

    }

    /**
     *
     */
    public function testSetAndGetTaxonomy()
    {

        $field = new Relationship('', '', '');

        $this->assertEquals([], $field->getTaxonomy());

        $field->setTaxonomy(['custom1', 'custom2']);

        $this->assertEquals(['custom1', 'custom2'], $field->getTaxonomy());

    }

}
