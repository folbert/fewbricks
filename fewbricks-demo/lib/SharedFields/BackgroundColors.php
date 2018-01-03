<?php

namespace App\FewbricksDemo\SharedFields;

use Fewbricks\ACF\Fields\Select;
use Fewbricks\SharedFields;

/**
 * Class BackgroundColors
 *
 * @package App\FewbricksDemo\SharedFields
 */
class BackgroundColors extends SharedFields
{

    /**
     *
     */
    protected function applyFields()
    {

        $this->addField(
            (new Select('Background color', 'background_color', '1712262153a'))
                ->setChoices([
                    'blue'  => 'Blue',
                    'green' => 'Green',
                    'red'   => 'Red',
                ])
                ->setDefaultValue('green')
        );

    }


}
