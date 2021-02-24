<?php
/**
 * Created by PhpStorm.
 * User: bjorn.folbert
 * Date: 2018-12-09
 * Time: 16:13
 */

namespace Fewbricks\Tests\ACF\Fields;

use Fewbricks\ACF\Fields\Taxonomy;
use Fewbricks\Tests\ACF\FieldTest;
use Fewbricks\Tests\FieldHelper;

final class TaxonomyTest extends FieldTest
{

    // Will be used when creating the field object for this test
    const CLASS_NAME = 'Fewbricks\ACF\Fields\Taxonomy';

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
    public function testSetAndGetAddTerm()
    {

        $field = new Taxonomy('', '', '');

        $this->assertEquals(1, $field->get_add_term());

        $field->set_add_term(false);

        $this->assertEquals(false, $field->get_add_term());

    }

    /**
     *
     */
    public function testSetAndGetAllowNull()
    {

        $field = new Taxonomy('', '', '');

        $this->assertEquals(0, $field->get_allow_null());

        $field->set_allow_null(true);

        $this->assertEquals(true, $field->get_allow_null());

    }

    /**
     *
     */
    public function testSetAndGetFieldType()
    {

        $field = new Taxonomy('', '', '');

        $this->assertEquals('checkbox', $field->get_field_type());

        $field->set_field_type('radio');

        $this->assertEquals('radio', $field->get_field_type());

    }

    /**
     *
     */
    public function testSetAndGetLoadTerms()
    {

        $field = new Taxonomy('', '', '');

        $this->assertEquals(0, $field->get_load_terms());

        $field->set_load_terms(true);

        $this->assertEquals(true, $field->get_load_terms());

    }

    /**
     *
     */
    public function testSetAndGetReturnFormat()
    {

        $field = new Taxonomy('', '', '');

        $this->assertEquals('id', $field->get_return_format());

        $field->set_return_format(false);

        $this->assertEquals(false, $field->get_return_format());

    }

    /**
     *
     */
    public function testSetAndGetSaveTerms()
    {

        $field = new Taxonomy('', '', '');

        $this->assertEquals(0, $field->get_save_terms());

        $field->set_save_terms(true);

        $this->assertEquals(true, $field->get_save_terms());

    }

    /**
     *
     */
    public function testSetAndGetTaxonomy()
    {

        $field = new Taxonomy('', '', '');

        $this->assertEquals('category', $field->get_taxonomy());

        $field->set_taxonomy('custom_category_yd98goi');

        $this->assertEquals('custom_category_yd98goi', $field->get_taxonomy());

    }

}
