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

    /**
     *
     */
    public function testGetLabel()
    {

        $label = 'A label dh8hoil';

        $field = new Text($label, 'text', '1812132258a');

        $this->assertEquals($label, $field->getLabel());

    }

    /**
     *
     */
    public function testGetName()
    {

        $name = 'A name hsg78fik';

        $field = new Text('Text', $name, '1812132258a');

        $this->assertEquals($name, $field->getName());

    }

    public function testGetKey()
    {

        $key = '1812132258a';

        $field = new Text('Text', 'text', '1812132258a');

        $this->assertEquals($key, $field->getKey());

    }

    public function testGetDefaultValue()
    {

        $defaultValue = 'nb89godlbl.';

        $field = new Text('Text', 'text', '1812132258a');
        $field->setDefaultValue($defaultValue);

        $this->assertEquals($defaultValue, $field->getDefaultValue());

    }

    public function testGetInstructions()
    {

        $instructions = 'nb89godlbl.';

        $field = new Text('Text', 'text', '1812132258a');
        $field->setInstructions($instructions);

        $this->assertEquals($instructions, $field->getInstructions());

    }

    public function testGetRequired()
    {

        $required = true;

        $field = new Text('Text', 'text', '1812132258a');
        $field->setRequired($required);

        $this->assertEquals($required, $field->getRequired());

    }

    public function testGetSetting()
    {

        $settingName = 'name_dg9go';
        $settingValue = 'dn98dgol';

        $field = new Text('Text', 'text', '1812132258a');
        $field->setSetting($settingName, $settingValue);

        $this->assertEquals($settingValue, $field->getSetting($settingName));

    }

    public function testGetSettingDefaultValue()
    {

        $defaultValue = 'dh89gdwewo';

        $field = new Text('Text', 'text', '1812132258a');

        $this->assertEquals($defaultValue, $field->getSetting('setting_dhd08gol', $defaultValue));

    }

    public function testGetDisplayInFewbricksDevTools()
    {

        $display = true;

        $field = new Text('Text', 'text', '1812132258a');
        $field->setDisplayInFewbricksDevTools($display);

        $this->assertEquals($display, $field->getDisplayInFewbricksDevTools());

    }

    public function testGetWrapper()
    {

        $wrapper = [
            'id' => 'the id ohd39jil',
            'class' => 'classd 89dgdol',
            'width' => '108',
        ];

        $field = new Text('Text', 'text', '1812132258a');
        $field->setWrapper($wrapper);

        $this->assertEquals($wrapper, $field->getWrapper());

    }

    public function testGetAppend()
    {

        $append = 'Append ts9tgo';

        $field = new Text('Text', 'text', '1812132258a');
        $field->setAppend($append);

        $this->assertEquals($append, $field->getAppend());

    }

    public function testGetMaxlength()
    {

        $maxLength = 89;

        $field = new Text('Text', 'text', '1812132258a');
        $field->setMaxlength($maxLength);

        $this->assertEquals($maxLength, $field->getMaxlength());

    }

    public function testGetPlaceholder()
    {

        $placeholder = 'Placeholder s9togl';

        $field = new Text('Text', 'text', '1812132258a');
        $field->setPlaceholder($placeholder);

        $this->assertEquals($placeholder, $field->getPlaceholder());

    }

    public function testGetPrepend()
    {

        $prepend = 'Prepend s9d232';

        $field = new Text('Text', 'text', '1812132258a');
        $field->setPrepend($prepend);

        $this->assertEquals($prepend, $field->getPrepend());

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
        $field->setSetting('custom_setting', 'custom_setting_value');
        $expectedArray['custom_setting'] = 'custom_setting_value';

        $field->setSettings([
            'custom_setting2' => 'custom_setting_value2',
            'custom_setting3' => 'custom_setting_value3',
        ]);
        $expectedArray['custom_setting2'] = 'custom_setting_value2';
        $expectedArray['custom_setting3'] = 'custom_setting_value3';

        $field->setDisplayInFewbricksDevTools(true);
        $expectedArray['fewbricks__display_in_dev_tools'] = true;

        $expectedArray = array_merge(
            FieldHelper::getExpectedFieldValues($field, $settings),
            $expectedArray
        );

        $expectedArray['wrapper']['width'] = '';

        $this->assertEquals(
            $expectedArray,
            $field->toAcfArray($settings['test__key_prefix'])
        );

    }

}
