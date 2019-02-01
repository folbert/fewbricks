<?php

namespace Fewbricks\Templating;

use Fewbricks\Brick;

/**
 * Class Helper
 * @package Fewbricks\Templating
 */
class Helper
{

    /**
     * @return mixed
     */
    public static function get_brick_layouts_base_path()
    {

        return apply_filters('fewbricks/templater/brick_layouts_base_path', false);

    }

    /**
     * @param $brick_object
     *
     * @return mixed
     */
    public static function get_brick_template_file_name($brick_object)
    {

        $namespaced_pieces = explode('\\', get_class($brick_object));
        $class_name = array_pop($namespaced_pieces);

        // Turn CamelCaseFileNames to dashed-versions. (ClassName -> class-name)
        $dashed_class_name = preg_replace('/([A-Z]+)/', "-$1", lcfirst($class_name));

        $default_file_name = strtolower($dashed_class_name);
        $default_file_name .= apply_filters('fewbricks/templater/brick_views_file_name_structure', '.view');
        $default_file_name .= '.php';

        return apply_filters('fewbricks/templater/brick_template_file_name', $default_file_name, $brick_object);

    }

    /**
     * @param Brick $brick_object
     *
     * @return mixed
     */
    public static function get_brick_templates_base_path($brick_object)
    {

        return apply_filters('fewbricks/templater/brick_templates_base_path', false, $brick_object);

    }

    /**
     * @return mixed
     */
    public static function get_view_files_name_structure()
    {

        return apply_filters('fewbricks/templater/brick_views_file_name_structure', '.view');

    }

}
