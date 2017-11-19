<?php

namespace Fewbricks;

class PredefinedField {

    protected $acf_settings;

    /**
     * PredefinedField constructor.
     *
     * @param string $key The key that the field instance wil get
     * @param array $acf_settings
     * @param array $args
     */
    public function __construct($key, $acf_settings = [], $args = [])
    {

        if(!is_array($acf_settings)) {
            $acf_settings = [];
        }

        $acf_settings['key'] = $key;

        $this->get();

    }

}
