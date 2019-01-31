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
    public function set_up()
    {

        $text = (new Text('Text', 'text', '1811292152a'))
            ->set_required(true);

        $image = (new Image('Image', 'image', '1811272243a'))
            ->set_required(true)
            ->setMinWidth(400)
            ->setMinHeight(400)
            ->setMaxWidth(1200)
            ->setMaxHeight(1200);

        $this->add_fields([$text, $image]);

    }

    /**
     * @return array
     */
    public function getViewData()
    {

        return $this->getFieldValues(['text', 'image']);

    }

}
