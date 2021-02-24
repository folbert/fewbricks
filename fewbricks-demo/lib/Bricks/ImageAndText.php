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
            ->set_min_width(400)
            ->set_min_height(400)
            ->set_max_width(1200)
            ->set_max_height(1200);

        $this->add_fields([$text, $image]);

    }

    /**
     * @return array
     */
    public function get_view_data()
    {

        return $this->get_field_values(['text', 'image']);

    }

}
