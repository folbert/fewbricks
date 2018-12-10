<?php

namespace Fewbricks\Tests\ACF;

use Fewbricks\ACF\ConditionalLogicRule;
use Fewbricks\ACF\ConditionalLogicRuleGroup;
use Fewbricks\ACF\Fields\Text;
use PHPUnit\Framework\TestCase;

class Field extends TestCase
{

    /**
     *
     */
    public function testAddingParent()
    {

        $textField = new Text('Text field with parent', 'text_field_with_parent', '1812102131b');
        $textField->addParent('parent1_key', 'parent1_name', 'Parent1Type');
        $textField->addParent('parent2_key', 'parent2_name', 'Parent2Type');

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
            $textField->toAcfArray()['fewbricks__parents']
        );

    }

    /**
     * Key altering wil take place when testing FieldGroup
     */
    public function testConditionalLogicWithoutAlteringKey()
    {

        $textField = new Text('Text field with conditional logic', 'text_field_with_conditional_logic', '1812102131a');

        $textField->addConditionalLogicRuleGroup(
            (new ConditionalLogicRuleGroup())
                ->addConditionalLogicRule(
                    new ConditionalLogicRule('the_param', '==', 'the_value')
                )
                ->addConditionalLogicRule(
                    new ConditionalLogicRule('the_param2', '==', 'the_value2')
                )
        );

        $textField->addConditionalLogicRuleGroup(
            (new ConditionalLogicRuleGroup())
                ->addConditionalLogicRule(
                    new ConditionalLogicRule('the_param3', '==', 'the_value3')
                )
                ->addConditionalLogicRule(
                    new ConditionalLogicRule('the_param4', '==', 'the_value4')
                )
        );

        $textField->addConditionalLogicRuleGroups([
                (new ConditionalLogicRuleGroup())
                    ->addConditionalLogicRule(
                        new ConditionalLogicRule('the_param5', '==', 'the_value5')
                    )
                    ->addConditionalLogicRule(
                        new ConditionalLogicRule('the_param6', '!=', '')
                    ),
                (new ConditionalLogicRuleGroup())
                    ->addConditionalLogicRule(
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
            $textField->toAcfArray()['conditional_logic']
        );

    }

}
