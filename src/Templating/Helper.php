<?php

namespace Fewbricks\Templating;

/**
 * Class Helper
 * @package Fewbricks\Templating
 */
class Helper
{

    /**
     * @return mixed|void
     */
    public static function getBrickLayoutsBasePath()
    {

        return apply_filters('fewbricks/templater/brick_layouts_base_path', false);

    }

    /**
     * @param $brick_object
     *
     * @return mixed
     */
    public static function getBrickTemplateFileName($brick_object)
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
     * @param object $brick_object
     *
     * @return mixed|void
     */
    public static function getBrickTemplatesBasePath($brick_object)
    {

        return apply_filters('fewbricks/templater/brick_templates_base_path', false, $brick_object);

    }

    /**
     * @return mixed
     */
    public static function getViewFilesNameStructure()
    {

        return apply_filters('fewbricks/templater/brick_views_file_name_structure', '.view');

    }


}
