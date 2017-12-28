<?php

namespace App\FewbricksDemo\Bricks;

use App\FewbricksDemo\ProjectBrick;

/**
 * Class Wysiwyg
 *
 * @package App\FewbricksDemo\Bricks
 */
class Wysiwyg extends ProjectBrick
{

    protected $name = 'WYSIWYG';

    /**
     *
     */
    public function setFields()
    {

        $this->addField(new \Fewbricks\ACF\Fields\Wysiwyg('WYSIWYG', 'wysiwyg', '1712282148a'));

    }


}
