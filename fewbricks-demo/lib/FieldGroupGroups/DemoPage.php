<?php

namespace App\FewbricksDemo\FieldGroupGroups;

use App\FewbricksDemo\FieldGroups\FieldsKitchenSink;
use Fewbricks\ACF\Field;
use Fewbricks\ACF\FieldGroup;
use Fewbricks\ACF\FieldGroupLocationRuleGroup;
use Fewbricks\ACF\Fields\Textarea;
use Fewbricks\ACF\Rule;
use Fewbricks\FieldGroupsCollection;

/**
 * Class Post
 *
 * @package App\Fewbricks\EditScreens
 */
class DemoPage extends FieldGroupsCollection
{

    /**
     *
     */
    private function addKitchenSinkFieldGroup()
    {

        // Adding a predefined field group
        $kitchenSinkFg = new FieldsKitchenSink('Fewbricks Demo - Kitchen Sink',
            '1711172225a');

        $kitchenSinkFg->addLocationRuleGroups($this->getFieldGroupLocationRuleGroups());
        
        $kitchenSinkFg->setMenuOrder(100);

        // Testing different ways to show/hide elements
        $kitchenSinkFg->showOnScreen('the_content');
        $kitchenSinkFg->hideOnScreen('the_content');
        $kitchenSinkFg->showOnScreen('the_content');
        $kitchenSinkFg->hideOnScreen('all');
        $kitchenSinkFg->showOnScreen('all');
        $kitchenSinkFg->hideOnScreen('all');
        $kitchenSinkFg->showOnScreen(['permalink', 'featured_image']);
        $kitchenSinkFg->hideOnScreen(['featured_image']);

        $this->addFieldGroup($kitchenSinkFg);

    }

    /**
     * This function is automatically called when the edit screen instance is created
     */
    public function build()
    {

        $this->addKitchenSinkFieldGroup();
        $this->createAndAddFieldGroupOnTheFly();

    }

    /**
     * Showing how to create field groups on the fly
     */
    private function createAndAddFieldGroupOnTheFly()
    {

        $contentFg = new FieldGroup('Fewbricks Demo - Main content',
            '1711162216a');

        $contentFg->addLocationRuleGroups($this->getFieldGroupLocationRuleGroups());

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

    /**
     * @return array
     */
    private function getFieldGroupLocationRuleGroups()
    {

        // The relation between each Rule within a RuleGroup is considered "and"
        // The relation between each RuleGroup is considered "or"
        return [
            (new FieldGroupLocationRuleGroup())
                ->addRule(new Rule('post_type', '==', 'fewbricks_demo_page')),
            (new FieldGroupLocationRuleGroup())
                ->addRule(new Rule('post_type', '==', 'fewbricks_demo_page2'))
                ->addRule(new Rule('post_type', '!=', 'fewbricks_demo_page3')),
        ];

    }

}
