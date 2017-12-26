<?php

namespace App\FewbricksDemo\PredefinedFields;

use Fewbricks\ACF\Fields\Select;
use Fewbricks\PredefinedField;

class BackgroundColors extends PredefinedField {

    /**
     * @return Select
     */
    public function get()
    {

        return new Select('Background colors', 'background_colors', $this->acf_settings['key'], $this->acf_settings);

    }


}
