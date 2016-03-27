<?php

namespace fewbricks\acf\fields;

/**
 * Class flexible_content
 */
class flexible_content extends field
{

    /**
     * @param string $label
     * @param string $name
     * @param string $key
     * @param array $custom_settings
     */
    public function __construct($label, $name, $key, $custom_settings = [])
    {
        $base_settings = [
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

        parent::__construct($label, $name, $key, $base_settings, $custom_settings);

    }

    /**
     * @param \fewbricks\acf\layout $layout
     * @return \fewbricks\acf\layout
     */
    public function add_layout($layout)
    {

        $this->settings['layouts'][] = $layout->get_settings();

        return $layout;

    }

    /**
     * @param array $layouts
     */
    public function add_layouts($layouts)
    {

        foreach ($layouts AS $layout) {

            $this->add_layout($layout);

        }

    }

    /**
     * @return \fewbricks\brick
     */
    public static function get_sub_field_brick_instance()
    {

        $row_layout = get_row_layout();

        $class_name = 'fewbricks\bricks\\' . self::get_sub_field_brick_class_name();
        
        $instance = new $class_name($row_layout);

        /** @noinspection PhpUndefinedMethodInspection */
        $instance->set_is_layout(true);

        return $instance;

    }

    /**
     * @return string
     */
    public static function get_sub_field_brick_class_name() {

        $row_layout = get_row_layout();

        $class_name = (get_sub_field($row_layout . '_brick_class'));

        if (is_null($class_name)) {

            die('get_sub_field_brick_instance() could not find a hidden field named ' . $row_layout . '_brick_class .');

        }

        return $class_name;

    }

}