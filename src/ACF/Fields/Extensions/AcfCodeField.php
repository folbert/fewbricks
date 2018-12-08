<?php

namespace Fewbricks\ACF\Fields\Extensions;

use Fewbricks\ACF\Field;

class AcfCodeField extends Field
{

    const TYPE = 'acf_code_field';

    /**
     * @param $mode string Possible values: 'htmlmixed', 'javascript', 'text/html', 'css', 'application/x-httpd-php'
     * @return $this
     */
    public function setMode($mode)
    {

        return $this->setSetting('mode', $mode);

    }

    /**
     * @param string $placeholder
     * @return $this
     */
    public function setPlaceholder($placeholder)
    {

        return $this->setSetting('placeholder', $placeholder);

    }

    /**
     * @param $theme
     * @return $this
     */
    public function setTheme($theme)
    {

        return $this->setSetting('theme', $theme);

    }

    /**
     * @return mixed
     */
    public function getMode()
    {

        return $this->getSetting('mode', 'monokai');

    }

    /**
     * @return mixed
     */
    public function getPlaceholder()
    {

        return $this->getSetting('placeholder', '');

    }

    /**
     * @return mixed
     */
    public function getTheme()
    {

        return $this->getSetting('theme', 'htmlmixed');

    }

    /**
     * This function is called right before field is turned into ACF array.
     */
    protected function prepareForAcfArray()
    {

        // Fix since the field does not check if placeholder is set before using the value.
        if($this->getSetting('placeholder', false) === false) {
            $this->setPlaceholder('');
        }

    }

}
