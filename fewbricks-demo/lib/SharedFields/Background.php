<?php

namespace App\FewbricksDemo\SharedFields;

use Fewbricks\ACF\Fields\Image;
use Fewbricks\SharedFieldCollection;
use Fewbricks\SharedFields;

/**
 * Class Background
 *
 * @package App\FewbricksDemo\SharedFields
 */
class Background extends SharedFields
{

    /**
     * @throws \Fewbricks\KeyInUseException
     */
    protected function applyFields()
    {

        $this->addField(new Image('Background Image', 'background_image', '1712262215a'));

        $this->addFieldCollection(new BackgroundColors());

    }

}