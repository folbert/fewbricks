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
    public function set_mode($mode)
    {

        return $this->set_setting('mode', $mode);

    }

    /**
     * @param string $placeholder
     * @return $this
     */
    public function set_placeholder($placeholder)
    {

        return $this->set_setting('placeholder', $placeholder);

    }

    /**
     * @param $theme
     * @return $this
     */
    public function set_theme($theme)
    {

        return $this->set_setting('theme', $theme);

    }

    /**
     * @return mixed
     */
    public function get_mode()
    {

        return $this->get_setting('mode', 'htmlmixed');

    }

    /**
     * @return mixed
     */
    public function get_placeholder()
    {

        return $this->get_setting('placeholder', '');

    }

    /**
     * @return mixed
     */
    public function get_theme()
    {

        return $this->get_setting('theme', 'monokai');

    }

    /**
     * This function is called right before field is turned into ACF array.
     */
    protected function prepare_for_acf_array()
    {

        // Fix since the field does not check if placeholder is set before using the value.
        if($this->get_setting('placeholder', false) === false) {
            $this->set_placeholder('');
        }

    }

}
