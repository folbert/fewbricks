<?php
/**
 * Created by PhpStorm.
 * User: bjorn.folbert
 * Date: 2018-12-09
 * Time: 16:13
 */

namespace Fewbricks\Tests\ACF\Fields\Extensions;

use Fewbricks\ACF\Fields\Extensions\DynamicYearSelect;
use Fewbricks\Tests\ACF\FieldTest;
use Fewbricks\Tests\FieldHelper;

final class DynamicYearSelectTest extends FieldTest
{

    // Will be used when creating the field object for this test
    const CLASS_NAME = 'Fewbricks\ACF\Fields\Extensions\DynamicYearSelect';

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
    public function testSetAndGetCurrentYear()
    {

        $field = new DynamicYearSelect('', '', '');

        $this->assertEquals([
            'allow' => false,
            'label' => 'Current',
        ], $field->getCurrentYear());

        $newValue = [
            'allow' => true,
            'label' => 'dhd89gol',
        ];

        $field->setCurrentYear($newValue);

        $this->assertEquals($newValue, $field->getCurrentYear());

    }

    /**
     *
     */
    public function testSetAndGetNewestYear()
    {

        $field = new DynamicYearSelect('', '', '');

        $this->assertEquals([
            'method' => 'exact',
            'exact_year' => date('Y'),
            'relative_year' => 20,
            'relative_year_direction' => 'after'
        ], $field->getNewestYear());

        $newValue = [
            'method' => 'exact',
            'exact_year' => date('Y'),
            'relative_year' =>24,
            'relative_year_direction' => 'before'
        ];

        $field->setNewestYear($newValue);

        $this->assertEquals($newValue, $field->getNewestYear());

    }

    /**
     *
     */
    public function testSetAndGetOldestYear()
    {

        $field = new DynamicYearSelect('', '', '');

        $this->assertEquals([
            'method' => 'relative',
            'exact_year' => date('Y'),
            'relative_year' => 20,
            'relative_year_direction' => 'before',
        ], $field->getOldestYear());

        $newValue = [
            'method' => 'exact',
            'exact_year' => date('Y'),
            'relative_year' =>24,
            'relative_year_direction' => 'after'
        ];

        $field->setOldestYear($newValue);

        $this->assertEquals($newValue, $field->getOldestYear());

    }

    /**
     *
     */
    public function testSetAndGetOrderBy()
    {

        $field = new DynamicYearSelect('', '', '');

        $this->assertEquals('chronological', $field->getOrderBy());

        $field->setOrderBy('rchronological');

        $this->assertEquals('rchronological', $field->getOrderBy());

    }

    /**
     *
     */
    public function testSetAndGetYearStep()
    {

        $field = new DynamicYearSelect('', '', '');

        $this->assertEquals(1, $field->getYearStep());

        $field->setYearStep(678);

        $this->assertEquals(678, $field->getYearStep());

    }

}
