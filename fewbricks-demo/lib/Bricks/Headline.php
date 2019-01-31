<?php

namespace FewbricksDemo\Bricks;

use Fewbricks\ACF\Fields\Select;
use Fewbricks\ACF\Fields\Text;

class Headline extends Brick
{

    const NAME = 'headline';

    /**
     *
     */
    public function set_up()
    {

        $level = new Select('Headline level', 'level', '1811272226a');
        $level->set_choices([
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
        ])
            ->set_allow_null(false)
            ->set_required(true);

        $this->add_field($level);

        $text = new Text('Text', 'text', '1811272243a');
        $text->set_required(true)
            ->set_placeholder('Enter a great headline here');

        $this->add_field($text);

    }

    /**
     * @return array
     */
    public function getViewData()
    {

        return $this->getFieldValues(['level', 'text']);

    }

}
