<?php
/**
 * Created by PhpStorm.
 * User: bjorn.folbert
 * Date: 2018-12-09
 * Time: 16:13
 */

namespace Fewbricks\Tests\ACF\Fields;

use Fewbricks\ACF\Fields\Select;
use Fewbricks\Tests\ACF\FieldTest;
use Fewbricks\Tests\FieldHelper;

final class SelectTest extends FieldTest
{

    // Will be used when creating the field object for this test
    const CLASS_NAME = 'Fewbricks\ACF\Fields\Select';

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
            'label' => 'A select field',
            'name' => 'name_of_the_select_field_et87giu',
            'key' => '1812101016a',
            // Internal test data that wil be removed when creating expected value
            'test__key_prefix' => '1812101016b',
            // These wil be set using setters on the field object
            'required' => true,
            'default_value' => 'Roland Deschain',
            'choices' => [
                'one' => 'One',
                'two' => 'Two',
            ]
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
    public function testSetAndGetAjax()
    {

        $field = new Select('', '', '');

        $this->assertEquals(0, $field->getAjax());

        $field->setAjax(true);

        $this->assertEquals(true, $field->getAjax());

    }

    /**
     *
     */
    public function testSetAndGetAllowNull()
    {

        $field = new Select('', '', '');

        $this->assertEquals(0, $field->getAllowNull());

        $field->setAllowNull(true);

        $this->assertEquals(true, $field->getAllowNull());

    }

    /**
     *
     */
    public function testSetAndGetChoices()
    {

        $field = new Select('', '', '');

        $this->assertEquals([], $field->getChoices());

        $field->setChoices(['sjoil', 'dgiuv']);

        $this->assertEquals(['sjoil', 'dgiuv'], $field->getChoices());

    }

    /**
     *
     */
    public function testSetAndGetDefaultValue()
    {

        $field = new Select('', '', '');

        $this->assertEquals('', $field->getDefaultValue());

        $field->setDefaultValue('hoihl');

        $this->assertEquals('hoihl', $field->getDefaultValue());

    }

    /**
     *
     */
    public function testSetAndGetMultiple()
    {

        $field = new Select('', '', '');

        $this->assertEquals(false, $field->getMultiple());

        $field->setMultiple(true);

        $this->assertEquals(true, $field->getMultiple());

    }

    /**
     *
     */
    public function testSetAndGetReturnFormat()
    {

        $field = new Select('', '', '');

        $this->assertEquals('value', $field->getReturnFormat());

        $field->setReturnFormat('h98goil');

        $this->assertEquals('h98goil', $field->getReturnFormat());

    }

    /**
     *
     */
    public function testSetAndGetUi()
    {

        $field = new Select('', '', '');

        $this->assertEquals(false, $field->getUi());

        $field->setUi(true);

        $this->assertEquals(true, $field->getUi());

    }

}
