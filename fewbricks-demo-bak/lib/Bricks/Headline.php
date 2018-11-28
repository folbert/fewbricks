<?php

namespace App\FewbricksDemo\Bricks;

use App\FewbricksDemo\ProjectBrick;
use Fewbricks\ACF\Fields\Select;
use Fewbricks\ACF\Fields\Text;

/**
 * Class Headline
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
            $this->addBrick(
                (new Badge('badge', '1802090022a'))
                ->setFieldLabelsprefix('Badge - ')
            );
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

        if(!empty($this->getFieldValue('badge_text'))) {

            $viewData['badgeHtml'] = ($this->getChildBrick(__NAMESPACE__ . '\\Badge', 'badge'))->getHtml();

        }

        return $viewData;

    }


    /**
     * @return string
     */
    public function getBrickHtml()
    {

        return $this->getBrickTemplateHtml($this->getViewData());

    }

}
