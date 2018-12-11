<?php

namespace Fewbricks\Tests;

use Fewbricks\ACF\Fields\Textarea;
use Fewbricks\ACF\Fields\Url;
use Fewbricks\Brick;

class ImageAndTextBrick extends Brick {

    function setUp()
    {

        $this->addField(new Textarea('A textarea', 'my_textarea', '1812112246a'));

        $this->addField(new Url('The URL', 'my_url', '1811122246a'));

    }

}
