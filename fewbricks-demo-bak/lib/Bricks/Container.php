<?php

namespace App\FewbricksDemo\Bricks;

use App\FewbricksDemo\ProjectBrick;
use Fewbricks\ACF\Fields\Message;

class Container extends ProjectBrick
{

    public function setFields()
    {

        $this->addField(
            (new Message('', 'message', '1801102132a'))
            ->setMessage('This field represents a <a href="https://getbootstrap.com/docs/4.0/layout/overview/#containers">Bootstrap Container</a>.')
        );


    }

    public function getBrickHtml()
    {



    }


}
