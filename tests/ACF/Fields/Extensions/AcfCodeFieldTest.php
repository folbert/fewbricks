<?php
/**
 * Created by PhpStorm.
 * User: bjorn.folbert
 * Date: 2018-12-09
 * Time: 16:13
 */

namespace Fewbricks\Tests\ACF\Fields\Extensions;

use Fewbricks\ACF\Fields\Extensions\AcfCodeField;
use Fewbricks\Tests\ACF\FieldTest;
use Fewbricks\Tests\FieldHelper;

final class AcfCodeFieldTest extends FieldTest
{

    // Will be used when creating the field object for this test
    const CLASS_NAME = 'Fewbricks\ACF\Fields\Extensions\AcfCodeField';

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

        $settings['placeholder'] = ''; // Due to implementation fix for this field type

        $this->assertEquals(
            FieldHelper::getExpectedFieldValues($field, $settings),
            $field->to_acf_array($settings['test__key_prefix'])
        );

    }

    /**
     *
     */
    public function testSetAndget_mode()
    {

        $field = new AcfCodeField('', '', '');

        $this->assertEquals('htmlmixed', $field->get_mode());

        $field->set_mode('98wgois');

        $this->assertEquals('98wgois', $field->get_mode());

    }

    /**
     *
     */
    public function testSetAndGetPlaceholder()
    {

        $field = new AcfCodeField('', '', '');

        $this->assertEquals('', $field->get_placeholder());

        $field->set_placeholder('dh89egoil');

        $this->assertEquals('dh89egoil', $field->get_placeholder());

    }

    /**
     *
     */
    public function testSetAndGetTheme()
    {

        $field = new AcfCodeField('', '', '');

        $this->assertEquals('monokai', $field->get_theme());

        $field->set_theme('gd89ogoil');

        $this->assertEquals('gd89ogoil', $field->get_theme());

    }

}
