<?php

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

    public function testGetLabel()
    {

        $label = 'A label dh8hoil';

        $textField = new Text($label, 'text', '1812132258a');

        $this->assertEquals($label, $textField->getLabel());

    }

    public function testGetName()
    {

        $name = 'A name hsg78fik';

        $textField = new Text('Text', $name, '1812132258a');

        $this->assertEquals($name, $textField->getName());

    }

    public function testGetKey()
    {

        $key = '1812132258a';

        $textField = new Text('Text', 'text', '1812132258a');

        $this->assertEquals($key, $textField->getKey());

    }

    public function testGetDefaultValue()
    {

        $defaultValue = 'nb89godlbl.';

        $textField = new Text('Text', 'text', '1812132258a');
        $textField->setDefaultValue($defaultValue);

        $this->assertEquals($defaultValue, $textField->getDefaultValue());

    }

    public function testGetInstructions()
    {

        $instructions = 'nb89godlbl.';

        $textField = new Text('Text', 'text', '1812132258a');
        $textField->setInstructions($instructions);

        $this->assertEquals($instructions, $textField->getInstructions());

    }

    public function testGetRequired()
    {

        $required = true;

        $textField = new Text('Text', 'text', '1812132258a');
        $textField->setRequired($required);

        $this->assertEquals($required, $textField->getRequired());

    }

    public function testGetSetting()
    {

        $settingName = 'name_dg9go';
        $settingValue = 'dn98dgol';

        $textField = new Text('Text', 'text', '1812132258a');
        $textField->setSetting($settingName, $settingValue);

        $this->assertEquals($settingValue, $textField->getSetting($settingName));

    }

    public function testGetSettingDefaultValue()
    {

        $defaultValue = 'dh89gdwewo';

        $textField = new Text('Text', 'text', '1812132258a');

        $this->assertEquals($defaultValue, $textField->getSetting('setting_dhd08gol', $defaultValue));

    }

    public function testGetDisplayInFewbricksDevTools()
    {

        $display = true;

        $textField = new Text('Text', 'text', '1812132258a');
        $textField->setDisplayInFewbricksDevTools($display);

        $this->assertEquals($display, $textField->getDisplayInFewbricksDevTools());

    }

    public function testGetWrapper()
    {

        $wrapper = [
            'id' => 'the id ohd39jil',
            'class' => 'classd 89dgdol',
            'width' => '108',
        ];

        $textField = new Text('Text', 'text', '1812132258a');
        $textField->setWrapper($wrapper);

        $this->assertEquals($wrapper, $textField->getWrapper());

    }

    public function testGetAppend()
    {

        $append = 'Append ts9tgo';

        $textField = new Text('Text', 'text', '1812132258a');
        $textField->setAppend($append);

        $this->assertEquals($append, $textField->getAppend());

    }

    public function testGetMaxlength()
    {

        $maxLength = 89;

        $textField = new Text('Text', 'text', '1812132258a');
        $textField->setMaxlength($maxLength);

        $this->assertEquals($maxLength, $textField->getMaxlength());

    }

    public function testGetPlaceholder()
    {

        $placeholder = 'Placeholder s9togl';

        $textField = new Text('Text', 'text', '1812132258a');
        $textField->setPlaceholder($placeholder);

        $this->assertEquals($placeholder, $textField->getPlaceholder());

    }

    public function testGetPrepend()
    {

        $prepend = 'Prepend s9d232';

        $textField = new Text('Text', 'text', '1812132258a');
        $textField->setPrepend($prepend);

        $this->assertEquals($prepend, $textField->getPrepend());

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
