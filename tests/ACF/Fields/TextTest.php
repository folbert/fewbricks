<?php

namespace Fewbricks\Tests\ACF\Fields;

use Fewbricks\ACF\Fields\Text;
use Fewbricks\Tests\ACF\FieldTest;
use Fewbricks\Tests\FieldHelper;

final class TextTest extends FieldTest
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

        $field = FieldHelper::getCompleteFieldObject(self::CLASS_NAME, $settings, $this);

        $expectedArray = [];

        // Common to all fields
        $field->set_setting('custom_setting', 'custom_setting_value');
        $expectedArray['custom_setting'] = 'custom_setting_value';

        $field->set_settings([
            'custom_setting2' => 'custom_setting_value2',
            'custom_setting3' => 'custom_setting_value3',
        ]);
        $expectedArray['custom_setting2'] = 'custom_setting_value2';
        $expectedArray['custom_setting3'] = 'custom_setting_value3';

        $field->set_display_in_fewbricks_info_pane(true);
        $expectedArray['fewbricks__display_in_info_pane'] = true;

        $expectedArray = array_merge(
            FieldHelper::getExpectedFieldValues($field, $settings),
            $expectedArray
        );

        $expectedArray['wrapper']['width'] = '';

        $this->assertEquals(
            $expectedArray,
            $field->to_acf_array($settings['test__key_prefix'])
        );

    }

    public function testSetAndGetAppend()
    {

        $append = 'Append ts9tgo';

        $field = new Text('Text', 'text', '1812132258a');

        $this->assertEquals('', $field->get_append());

        $field->set_append($append);

        $this->assertEquals($append, $field->get_append());

    }

    public function testSetAndGetDefaultValue()
    {

        $defaultValue = 'nb89godlbl.';

        $field = new Text('Text', 'text', '1812132258a');

        $this->assertEquals('', $field->get_default_value());

        $field->set_default_value($defaultValue);

        $this->assertEquals($defaultValue, $field->get_default_value());

    }

    public function testSetAndGetMaxlength()
    {

        $maxLength = 89;

        $field = new Text('Text', 'text', '1812132258a');

        $this->assertEquals('', $field->get_maxlength());

        $field->set_maxlength($maxLength);

        $this->assertEquals($maxLength, $field->get_maxlength());

    }

    public function testSetAndGetPlaceholder()
    {

        $placeholder = 'Placeholder s9togl';

        $field = new Text('Text', 'text', '1812132258a');

        $this->assertEquals('', $field->get_placeholder());

        $field->set_placeholder($placeholder);

        $this->assertEquals($placeholder, $field->get_placeholder());

    }

    public function testSetAndGetPrepend()
    {

        $prepend = 'Prepend s9d232';

        $field = new Text('Text', 'text', '1812132258a');

        $this->assertEquals('', $field->get_prepend());

        $field->set_prepend($prepend);

        $this->assertEquals($prepend, $field->get_prepend());

    }

}
