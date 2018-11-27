<?php

namespace FewbricksDemo\Bricks;

use Fewbricks\ACF\Fields\Select;
use Fewbricks\ACF\Fields\Text;
use Fewbricks\Templater;

class Headline extends Brick {

    /**
     *
     */
    public function setFields()
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
        $text->setPlaceholder('A placeholder');
        $text->setDefaultValue('My neat headline text');
        $this->addField($text);

    }

    private function getViewData()
    {

        return $this->getFieldValues(['level', 'text']);

    }

    /**
     * @return string
     */
    public function getBrickHtml()
    {

        $viewData = $this->getViewData();

        if (!empty($viewData)) {
            $outcome = Templater::getBrickHtml($this, $this->getViewData());
        } else {
            $outcome = '';
        }

        return $outcome;

    }

}
