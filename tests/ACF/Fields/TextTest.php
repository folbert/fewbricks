<?php
/**
 * Created by PhpStorm.
 * User: bjorn.folbert
 * Date: 2018-12-09
 * Time: 16:13
 */

namespace Fewbricks\Tests\ACF\Fields;

use Fewbricks\ACF\Fields\Text;
use Fewbricks\Tests\ACF\Field;
use Fewbricks\Tests\FieldHelper;

final class TextTest extends Field
{

    // Will be used when creating the field object for this test
    const CLASS_NAME = 'Fewbricks\ACF\Fields\Text';

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
            'label' => 'A text field',
            'name' => 'name_of_the_text_field_et87giu',
            'key' => '1812092118a',
            // Internal test data that wil be removed when creating expected value
            'test__key_prefix' => '1812092118b',
            // These will be set using setters on the field object
            // Common for all fields
            'default_value' => 'Roland Deschain',
            'instructions' => 'Some text instructions',
            'required' => true,
            'wrapper' => [
                'id' => 'wrapper_id',
                'class' => 'wrapper_class',
            ],
            // Specific for this field type
            'append' => 'Appended to text field',
            'maxlength' => 10,
            'placeholder' => 'A placeholder',
            'prepend' => 'Text field prepend',
        ];

        $textField = FieldHelper::getCompleteFieldObject(self::CLASS_NAME, $settings, $this);

        $expectedArray = [];

        // Common to all fields
        $textField->setSetting('custom_setting', 'custom_setting_value');
        $expectedArray['custom_setting'] = 'custom_setting_value';

        $textField->setSettings([
            'custom_setting2' => 'custom_setting_value2',
            'custom_setting3' => 'custom_setting_value3',
        ]);
        $expectedArray['custom_setting2'] = 'custom_setting_value2';
        $expectedArray['custom_setting3'] = 'custom_setting_value3';

        $textField->setDisplayInFewbricksDevTools(true);
        $expectedArray['fewbricks__display_in_dev_tools'] = true;

        $expectedArray = array_merge(
            FieldHelper::getExpectedFieldValues($textField, $settings),
            $expectedArray
        );

        $expectedArray['wrapper']['width'] = '';

        $this->assertEquals(
            $expectedArray,
            $textField->toAcfArray($settings['test__key_prefix'])
        );

    }

}
