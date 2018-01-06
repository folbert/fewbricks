<?php

namespace App\FewbricksDemo\Bricks;

use App\FewbricksDemo\ProjectBrick;
use Fewbricks\ACF\Fields\Select;
use Fewbricks\ACF\Fields\Text;

/**
 * Class Wysiwyg
 *
 * @package App\FewbricksDemo\Bricks
 */
class Headline extends ProjectBrick
{

    protected $name = 'Headline';

    /**
     *
     */
    public function setFields()
    {

        $this->addField(new Text('Text', 'text', '1801060126a'));

        $this->addLevelsOptions();

        if ($this->getArgument('show_badge', false)) {
            $this->addField(new Text('Badge', 'badge', '1801060145a'));
        }

    }

    /**
     *
     */
    private function addLevelsOptions()
    {

        if (!$this->getArgument('hide_levels', false)) {

            $levels = $this->getArgument('levels', false);

            if ($levels === false) {

                $levels = [
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                ];

            }

            $this->addField(
                (new Select('Level', 'level', '1801060155a'))
                    ->setChoices($levels)
            );

        }

    }

    /**
     * @return array
     */
    private function getViewData()
    {

        $viewData = $this->getFieldValues([
            'text',
            'badge',
            'level',
        ]);

        dump($viewData);

        return $viewData;

    }


    /**
     * @return string
     */
    public function getBrickHtml()
    {

        $this->getViewData();

        return $this->getBrickTemplateHtml($this->getViewData());

    }

}
