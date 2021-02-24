<?php
/**
 * Created by PhpStorm.
 * User: bjorn.folbert
 * Date: 2018-12-09
 * Time: 16:13
 */

namespace Fewbricks\Tests\ACF\Fields;

use Fewbricks\ACF\Fields\Accordion;
use Fewbricks\Tests\ACF\FieldTest;
use Fewbricks\Tests\FieldHelper;

final class AccordionTest extends FieldTest
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
            $field->to_acf_array($settings['test__key_prefix'])
        );

    }

    public function testSetAndGetEndpoint()
    {

        $field = new Accordion('', '', '');

        $this->assertEquals(0, $field->get_endpoint());

        $field->set_endpoint(false);

        $this->assertEquals(false, $field->get_endpoint());

    }

    public function testSetAndGetMultiExpand()
    {

        $field = new Accordion('', '', '');

        $this->assertEquals(0, $field->get_multi_expand());

        $field->set_multi_expand(false);

        $this->assertEquals(false, $field->get_multi_expand());

    }

    public function testSetAndGetOpen()
    {

        $field = new Accordion('', '', '');

        // Default
        $this->assertEquals(0, $field->get_open());

        $field->setOpen(true);

        $this->assertEquals(true, $field->get_open());

    }

}
