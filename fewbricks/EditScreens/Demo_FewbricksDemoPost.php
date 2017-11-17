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
class FewbricksDemoPost extends EditScreen
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

        $this->create_field_group_on_the_fly();

        $kitchen_sink_fg = new FewbricksFieldGroups\DemoKitchenSink('Fewbricks Demo - Kitchen Sink', '1711172225a');
        $kitchen_sink_fg->build();
        $this->addFieldGroup($kitchen_sink_fg);

    }

    /**
     * Showing how to create field groups on the fly
     */
    private function create_field_group_on_the_fly()
    {

        $contentFg = new FieldGroup('Fewbricks Demo - Main content', '1711162216a');

        $contentFg->addField(new Field('text', 'Text', 'sometext',
            '1711162243a'));
        $contentFg->addField(new Textarea('Text2', 'someothertext',
            '1711162243b'));

        $this->addFieldGroup($contentFg);

    }

}
