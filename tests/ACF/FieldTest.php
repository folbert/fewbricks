<?php

namespace Fewbricks\Tests\ACF;

use Fewbricks\ACF\ConditionalLogicRule;
use Fewbricks\ACF\ConditionalLogicRuleGroup;
use Fewbricks\ACF\Fields\Text;
use PHPUnit\Framework\TestCase;

class FieldTest extends TestCase
{

    /**
     *
     */
    public function testGetLabel()
    {

        $label = 'A label dh8hoil';

        $field = new Text($label, 'text', '1812132258a');

        $this->assertEquals($label, $field->get_label());

    }

    /**
     *
     */
    public function testGetName()
    {

        $name = 'A name hsg78fik';

        $field = new Text('Text', $name, '1812132258a');

        $this->assertEquals($name, $field->get_name());

    }

    public function testGetKey()
    {

        $key = '1812132258a';

        $field = new Text('Text', 'text', '1812132258a');

        $this->assertEquals($key, $field->get_key());

    }

    public function testSetAndGetInstructions()
    {

        $instructions = 'nb89godlbl.';

        $field = new Text('Text', 'text', '1812132258a');

        $field->set_instructions($instructions);

        $this->assertEquals($instructions, $field->get_instructions());

    }

    public function testSetAndGetRequired()
    {

        $required = true;

        $field = new Text('Text', 'text', '1812132258a');
        $field->set_required($required);

        $this->assertEquals($required, $field->get_required());

    }

    public function testSetAndGetSetting()
    {

        $settingName = 'name_dg9go';
        $settingValue = 'dn98dgol';

        $field = new Text('Text', 'text', '1812132258a');

        $field->set_setting($settingName, $settingValue);

        $this->assertEquals($settingValue, $field->get_setting($settingName));

    }

    public function testGetSettingDefaultValue()
    {

        $defaultValue = 'dh89gdwewo';

        $field = new Text('Text', 'text', '1812132258a');

        $this->assertEquals($defaultValue, $field->get_setting('setting_dhd08gol', $defaultValue));

    }

    public function testSetAndGetDisplayInFewbricksInfoPane()
    {

        $display = true;

        $field = new Text('Text', 'text', '1812132258a');

        $field->set_display_in_fewbricks_info_pane($display);

        $this->assertEquals($display, $field->get_display_in_fewbricks_info_pane());

    }

    public function testSetAndGetWrapper()
    {

        $wrapper = [
            'id' => 'the id ohd39jil',
            'class' => 'classd 89dgdol',
            'width' => '108',
        ];

        $field = new Text('Text', 'text', '1812132258a');

        $field->set_wrapper($wrapper);

        $this->assertEquals($wrapper, $field->get_wrapper());

    }

    /**
     *
     */
    public function testAddParent()
    {

        $textField = new Text('Text field with parent', 'text_field_with_parent', '1812102131b');
        $textField->add_parent('parent1_key', 'parent1_name', 'Parent1Type');
        $textField->add_parent('parent2_key', 'parent2_name', 'Parent2Type');

        $this->assertEquals([
            [
                'key' => 'parent1_key',
                'name' => 'parent1_name',
                'type' => 'Parent1Type',
            ],
            [
                'key' => 'parent2_key',
                'name' => 'parent2_name',
                'type' => 'Parent2Type',
            ],
        ],
            $textField->to_acf_array()['fewbricks__parents']
        );

    }

    /**
     * Key altering wil take place when testing FieldGroup
     */
    public function testConditionalLogicWithoutAlteringKey()
    {

        $textField = new Text('Text field with conditional logic', 'text_field_with_conditional_logic', '1812102131a');

        $textField->add_conditional_logic_rule_group(
            (new ConditionalLogicRuleGroup())
                ->add_conditional_logic_rule(
                    new ConditionalLogicRule('the_param', '==', 'the_value')
                )
                ->add_conditional_logic_rule(
                    new ConditionalLogicRule('the_param2', '==', 'the_value2')
                )
        );

        $textField->add_conditional_logic_rule_group(
            (new ConditionalLogicRuleGroup())
                ->add_conditional_logic_rule(
                    new ConditionalLogicRule('the_param3', '==', 'the_value3')
                )
                ->add_conditional_logic_rule(
                    new ConditionalLogicRule('the_param4', '==', 'the_value4')
                )
        );

        $textField->add_conditional_logic_rule_groups([
                (new ConditionalLogicRuleGroup())
                    ->add_conditional_logic_rule(
                        new ConditionalLogicRule('the_param5', '==', 'the_value5')
                    )
                    ->add_conditional_logic_rule(
                        new ConditionalLogicRule('the_param6', '!=', '')
                    ),
                (new ConditionalLogicRuleGroup())
                    ->add_conditional_logic_rule(
                        new ConditionalLogicRule('the_param7', '==', 'the_value7')
                    )
            ]

        );

        $this->assertEquals([
            [
                [
                    'field' => 'the_param',
                    'operator' => '==',
                    'value' => 'the_value',
                ],
                [
                    'field' => 'the_param2',
                    'operator' => '==',
                    'value' => 'the_value2'
                ]
            ],
            [
                [
                    'field' => 'the_param3',
                    'operator' => '==',
                    'value' => 'the_value3',
                ],
                [
                    'field' => 'the_param4',
                    'operator' => '==',
                    'value' => 'the_value4'
                ]
            ],
            [
                [
                    'field' => 'the_param5',
                    'operator' => '==',
                    'value' => 'the_value5',
                ],
                [
                    'field' => 'the_param6',
                    'operator' => '!=',
                    'value' => ''
                ]
            ],
            [
                [
                    'field' => 'the_param7',
                    'operator' => '==',
                    'value' => 'the_value7',
                ],
            ],
        ],
            $textField->to_acf_array()['conditional_logic']
        );

    }

}
