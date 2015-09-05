<?php

namespace fewbricks\acf\fields;

/**
 * Class flexible_content
 */
class flexible_content extends field
{

    /**
     * @param $label
     * @param $name
     * @param $key
     */
    public function __construct($label, $name, $key)
    {
        $settings = [
            'prefix' => '',
            'type' => 'flexible_content',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => [
                'width' => '',
                'class' => '',
                'id' => '',
            ],
            'button_label' => 'Add module',
            'min' => '',
            'max' => '',
            'layouts' => []
        ];

        parent::__construct($label, $name, $key, $settings);

    }

    /**
     * @param layout $layout
     * @return layout
     */
    public function add_layout($layout)
    {

        $this->settings['layouts'][] = $layout->get_settings();

        return $layout;

    }

    /**
     * @param $layouts
     */
    public function add_layouts($layouts)
    {

        foreach ($layouts AS $layout) {

            $this->add_layout($layout);

        }

    }

}