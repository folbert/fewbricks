<?php

namespace App\Fewbricks\EditScreens;

use \App\Fewbricks\FieldGroups as FewbricksFieldGroups;
use Fewbricks\ACF\Field;
use Fewbricks\ACF\FieldGroup;
use Fewbricks\ACF\Fields\Textarea;
use Fewbricks\EditScreen;

/**
 * Class Post
 *
 * @package App\Fewbricks\EditScreens
 */
class Demo_FewbricksDemoPost extends EditScreen
{

    protected $location
        = [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'fewbricks_demo_post',
                ],
            ],
        ];

    /**
     * This function is automatically called when the edit screen instance is created
     */
    public function build()
    {

        // Adding a predefined field group
        $kitchenSinkFg
            = new FewbricksFieldGroups\Demo_FieldsKitchenSink('Fewbricks Demo - Kitchen Sink',
            '1711172225a', $this->location);

        $kitchenSinkFg->setHideOnScreen(false, ['permalink']);
        $kitchenSinkFg->setMenuOrder(100);

        $this->addFieldGroup($kitchenSinkFg);

        $this->create_field_group_on_the_fly();

    }

    /**
     * Showing how to create field groups on the fly
     */
    private function create_field_group_on_the_fly()
    {

        $contentFg = new FieldGroup('Fewbricks Demo - Main content',
            '1711162216a', $this->location);

        $contentFg->setSetting('menu_order', 110);
        //$contentFg->setHideOnScreen(['permalink']);

        // Create a field directly
        $contentFg->addField(new \Fewbricks\ACF\Fields\Field('text', 'Text', 'sometext',
            '1711162243a'));
        $contentFg->addField(new Textarea('Text2', 'someothertext',
            '1711162243b'));

        $this->addFieldGroup($contentFg);

    }

}
