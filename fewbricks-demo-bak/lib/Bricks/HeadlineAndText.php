<?php

namespace App\FewbricksDemo\Bricks;

use App\FewbricksDemo\ProjectBrick;
use Fewbricks\ACF\Fields\Textarea;

/**
 * Class Wysiwyg
 *
 * @package App\FewbricksDemo\Bricks
 */
class HeadlineAndText extends ProjectBrick
{

    protected $name = 'Headline and text';

    /**
     * @return string
     */
    protected function getBrickHtml()
    {

        return $this->getChildBrick('App\FewbricksDemo\Bricks\Headline', 'headline')->getHtml();

    }

    /**
     *
     */
    public function setFields()
    {

        $this->addBrick(
            (new Headline('headline', '1801060149a'))
                ->setArgument('show_badge', $this->getArgument('show_badge', false))
        );

        $this->addField(new Textarea('Text', 'text', '1801060126b'));

    }


}
