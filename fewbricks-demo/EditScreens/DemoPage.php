<?php

namespace App\Fewbricks\EditScreens;

use \App\Fewbricks\FieldGroups as FewbricksFieldGroups;
use Fewbricks\ACF\Field;
use Fewbricks\ACF\FieldGroup;
use Fewbricks\ACF\FieldGroupLocationRuleGroup;
use Fewbricks\ACF\Fields\Textarea;
use Fewbricks\ACF\Rule;
use Fewbricks\EditScreen;

/**
 * Class Post
 *
 * @package App\Fewbricks\EditScreens
 */
class DemoPage extends EditScreen
{

    /**
     * This function is automatically called when the edit screen instance is created
     */
    public function build()
    {

        $this->addKitchenSinkFieldGroup();
        $this->createAndAddFieldGroupOnTheFly();

    }

    /**
     * @return array
     */
    private function getFieldGroupLocationFieldGroups()
    {

        // The relation between each Rule within a RuleGroup is considered "and"
        // The relation between each RuleGroup is considered "or"
        return [
            (new FieldGroupLocationRuleGroup())
                ->addRule(new Rule('post_type', '==', 'fewbricks_demo_page')),
            (new FieldGroupLocationRuleGroup())
                ->addRule(new Rule('post_type', '==', 'fewbricks_demo_page2'))
                ->addRule(new Rule('post_type', '!=', 'fewbricks_demo_page3'))
        ];

    }

    /**
     *
     */
    private function addKitchenSinkFieldGroup()
    {

        // Adding a predefined field group
        $kitchenSinkFg
            = new FewbricksFieldGroups\Demo_FieldsKitchenSink('Fewbricks Demo - Kitchen Sink',
            '1711172225a');

        $kitchenSinkFg->addLocationRuleGroups($this->getFieldGroupLocationFieldGroups());

        $kitchenSinkFg->setHideOnScreen(false, ['permalink']);
        $kitchenSinkFg->setMenuOrder(100);

        $this->addFieldGroup($kitchenSinkFg);

    }

    /**
     * Showing how to create field groups on the fly
     */
    private function createAndAddFieldGroupOnTheFly()
    {

        $contentFg = new FieldGroup('Fewbricks Demo - Main content',
            '1711162216a');

        $contentFg->addLocationRuleGroups($this->getFieldGroupLocationFieldGroups());

        $contentFg->setSetting('menu_order', 110);

        // Create a field directly. This can come in handy if ACF releases new field types and you are running a
        // version of Fewbricks where the new field types has not yet been implemented.
        // Also showing that settings can be dynamically set
        $contentFg->addField(
            (new Field('Text', 'sometext', '1711162243a'))
                ->setType('text')
                ->setSetting('append', 'Appendix')
        );

        $contentFg->addField(new Textarea('Text2', 'someothertext',
            '1711162243b'));

        $this->addFieldGroup($contentFg);

    }

}
