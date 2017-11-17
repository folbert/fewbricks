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
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'fewbricks_demo_post',
                ],
            ],
        ];

    /**
     * This function is automatically called when the edit screen instance is created
     */
    public function build()
    {

        // Adding a pre defined field group
        $kitchen_sink_fg = new FewbricksFieldGroups\Demo_FieldsKitchenSink('Fewbricks Demo - Kitchen Sink', '1711172225a');
        $kitchen_sink_fg->setSetting('menu_order', 100);
        $kitchen_sink_fg->build();
        $this->addFieldGroup($kitchen_sink_fg);

        $this->create_field_group_on_the_fly();

    }

    /**
     * Showing how to create field groups on the fly
     */
    private function create_field_group_on_the_fly()
    {

        $contentFg = new FieldGroup('Fewbricks Demo - Main content', '1711162216a');
        $contentFg->setSetting('menu_order', 50);

        $contentFg->addField(new Field('text', 'Text', 'sometext',
            '1711162243a'));
        $contentFg->addField(new Textarea('Text2', 'someothertext',
            '1711162243b'));

        $this->addFieldGroup($contentFg);

    }

}
