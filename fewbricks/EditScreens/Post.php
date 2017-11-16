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
class Post extends EditScreen
{

    protected $location
        = [
            [
                [
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'post',
                ],
            ],
        ];

    /**
     *
     */
    public function build()
    {

        $contentFg = new FieldGroup('Main content', '1711162216a');

        $contentFg->addField(new Field('text', 'Text', 'sometext',
            '1711162243a'));
        $contentFg->addField(new Textarea('Text2', 'someothertext',
            '1711162243b'));

        $this->addFieldGroup($contentFg);

    }

}
