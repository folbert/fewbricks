<?php

namespace Fewbricks\Tests;

use Fewbricks\ACF\Fields\Text;
use Fewbricks\ACF\Fields\Url;
use Fewbricks\Brick;

class TextAndUrlBrick extends Brick {

    function setUp()
    {

        $this->addField(new Text('A text', 'my_text', 'imageandtextbrickfield_text_key'));

        $this->addField(new Url('The URL', 'my_url', 'imageandtextbrickfield_url_key'));

    }

}
