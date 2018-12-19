<?php
/**
 * Created by PhpStorm.
 * User: bjorn.folbert
 * Date: 2018-12-09
 * Time: 16:13
 */

namespace Fewbricks\Tests\ACF\Fields;

use Fewbricks\ACF\Fields\Accordion;
use Fewbricks\Tests\ACF\Field;
use Fewbricks\Tests\FieldHelper;

final class AccordionTest extends Field
{

    // Will be used when creating the field object for this test
    const CLASS_NAME = 'Fewbricks\ACF\Fields\Accordion';

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

    public function testSetAndGetEndpoint()
    {

        $field = new Accordion('', '', '');

        $field->setEndpoint(true);

        $this->assertEquals(true, $field->getEndpoint());

        $field->setEndpoint(false);

        $this->assertEquals(false, $field->getEndpoint());

    }

    public function testSetAndGetMultiExpand()
    {

        $field = new Accordion('', '', '');

        $field->setMultiExpand(true);

        $this->assertEquals(true, $field->getMultiExpand());

        $field->setMultiExpand(false);

        $this->assertEquals(false, $field->getMultiExpand());

    }

    public function testSetAndGetOpen()
    {

        $field = new Accordion('', '', '');

        // Default
        $this->assertEquals('', $field->getOpen());

        $field->setOpen(true);

        $this->assertEquals(true, $field->getOpen());

    }

}
