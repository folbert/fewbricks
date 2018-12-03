<?php

namespace FewbricksDemo\Bricks;

use Fewbricks\ACF\Fields\Select;
use Fewbricks\ACF\Fields\Text;
use Fewbricks\BrickTemplater;

class Headline extends Brick {

    /**
     *
     */
    public function setup()
    {

        $level = new Select('Headline level', 'level', '1811272226a');
        $level->setChoices([
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
        ]);
        $level->setAllowNull(false);
        $level->setRequired(true);
        $this->addField($level);

        $text = new Text('Text', 'text', '1811272243a');
        $text->setRequired(true);
        $text->setPlaceholder('Enter a great headline here');
        $this->addField($text);

    }

    /**
     * @return array
     */
    public function getViewData()
    {

        return $this->getFieldValues(['level', 'text']);

    }

}
