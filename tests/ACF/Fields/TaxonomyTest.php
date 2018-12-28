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
            $field->toAcfArray($settings['test__key_prefix'])
        );

    }

    /**
     *
     */
    public function testSetAndGetAddTerm()
    {

        $field = new Taxonomy('', '', '');

        $this->assertEquals(1, $field->getAddTerm());

        $field->setAddTerm(false);

        $this->assertEquals(false, $field->getAddTerm());

    }

    /**
     *
     */
    public function testSetAndGetAllowNull()
    {

        $field = new Taxonomy('', '', '');

        $this->assertEquals(0, $field->getAllowNull());

        $field->setAllowNull(true);

        $this->assertEquals(true, $field->getAllowNull());

    }

    /**
     *
     */
    public function testSetAndGetFieldType()
    {

        $field = new Taxonomy('', '', '');

        $this->assertEquals('checkbox', $field->getFieldType());

        $field->setFieldType('radio');

        $this->assertEquals('radio', $field->getFieldType());

    }

    /**
     *
     */
    public function testSetAndGetLoadTerms()
    {

        $field = new Taxonomy('', '', '');

        $this->assertEquals(0, $field->getLoadTerms());

        $field->setLoadTerms(true);

        $this->assertEquals(true, $field->getLoadTerms());

    }

    /**
     *
     */
    public function testSetAndGetReturnFormat()
    {

        $field = new Taxonomy('', '', '');

        $this->assertEquals('id', $field->getReturnFormat());

        $field->setReturnFormat(false);

        $this->assertEquals(false, $field->getReturnFormat());

    }

    /**
     *
     */
    public function testSetAndGetSaveTerms()
    {

        $field = new Taxonomy('', '', '');

        $this->assertEquals(0, $field->getSaveTerms());

        $field->setSaveTerms(true);

        $this->assertEquals(true, $field->getSaveTerms());

    }

    /**
     *
     */
    public function testSetAndGetTaxonomy()
    {

        $field = new Taxonomy('', '', '');

        $this->assertEquals('category', $field->getTaxonomy());

        $field->setTaxonomy('custom_category_yd98goi');

        $this->assertEquals('custom_category_yd98goi', $field->getTaxonomy());

    }

}
