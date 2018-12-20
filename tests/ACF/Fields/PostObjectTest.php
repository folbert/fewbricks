<?php
/**
 * Created by PhpStorm.
 * User: bjorn.folbert
 * Date: 2018-12-09
 * Time: 16:13
 */

namespace Fewbricks\Tests\ACF\Fields;

use Fewbricks\ACF\Fields\PostObject;
use Fewbricks\Tests\ACF\Field;
use Fewbricks\Tests\FieldHelper;

final class PostObjectTest extends Field
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
            $field->toAcfArray($settings['test__key_prefix'])
        );

    }

    /**
     *
     */
    public function testSetAndGetAllowNull()
    {

        $field = new PostObject('', '', '');

        $this->assertEquals(false, $field->getAllowNull());

        $field->setAllowNull(true);

        $this->assertEquals(true, $field->getAllowNull());

    }

    /**
     *
     */
    public function testSetAndGetMultiple()
    {

        $field = new PostObject('', '', '');

        $this->assertEquals(false, $field->getMultiple());

        $field->setMultiple(true);

        $this->assertEquals(true, $field->getMultiple());

    }

    /**
     *
     */
    public function testSetAndGetPostType()
    {

        $field = new PostObject('', '', '');

        $this->assertEquals([], $field->getPostType());

        $field->setPostType(['page', 'custom']);

        $this->assertEquals(['page', 'custom'], $field->getPostType());

    }

    /**
     *
     */
    public function testSetAndGetReturnFormat()
    {

        $field = new PostObject('', '', '');

        $this->assertEquals('object', $field->getReturnFormat());

        $field->setReturnFormat('array');

        $this->assertEquals('array', $field->getReturnFormat());

    }

    /**
     *
     */
    public function testSetAndGetTaxonomy()
    {

        $field = new PostObject('', '', '');

        $this->assertEquals([], $field->getTaxonomy());

        $field->setTaxonomy(['categories', 'custom']);

        $this->assertEquals(['categories', 'custom'], $field->getTaxonomy());

    }

}
