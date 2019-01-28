<?php

namespace FewbricksDemo\Bricks;

use Fewbricks\ACF\Fields\Image;
use Fewbricks\ACF\Fields\Text;

class ImageAndText extends Brick
{

    const NAME = 'image_and_text';

    /**
     *
     */
    public function setUp()
    {

        $text = (new Text('Text', 'text', '1811292152a'))
            ->setRequired(true);

        $image = (new Image('Image', 'image', '1811272243a'))
            ->setRequired(true)
            ->setMinWidth(400)
            ->setMinHeight(400)
            ->setMaxWidth(1200)
            ->setMaxHeight(1200);

        $this->addFields([$text, $image]);

    }

    /**
     * @return array
     */
    public function getViewData()
    {

        return $this->getFieldValues(['text', 'image']);

    }

}
