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
     * @return brick
     */
    public static function get_sub_field_brick_instance()
    {

        $row_layout = get_row_layout();

        $class_name = (get_sub_field($row_layout . '_brick_class'));

        if (is_null($class_name)) {

            die('get_brick_class_name_of_layout() could not find a hidden field named ' . $base_name . '_brick_class .');

        }

        $class_name = 'fewbricks\bricks\\' . $class_name;

        $instance = new $class_name($row_layout);

        $instance->set_is_layout(true);

        return $instance;

    }

    /**
     * @return string
     */
    public static function get_brick_class_name()
    {



    }

}