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
    public static function getBrickLayoutsBasePath()
    {

        return apply_filters('fewbricks/templater/brick_layouts_base_path', false);

    }

    /**
     * @param $brickObject
     *
     * @return mixed
     */
    public static function getBrickTemplateFileName($brickObject)
    {

        $namespacedPieces = explode('\\', get_class($brickObject));
        $className = array_pop($namespacedPieces);

        // Turn CamelCaseFileNames to dashed-versions. (ClassName -> class-name)
        $dashedClassName = preg_replace('/([A-Z]+)/', "-$1", lcfirst($className));

        $defaultFileName = strtolower($dashedClassName);
        $defaultFileName .= apply_filters('fewbricks/templater/brick_views_file_name_structure', '.view');
        $defaultFileName .= '.php';

        return apply_filters('fewbricks/templater/brick_template_file_name', $defaultFileName, $brickObject);

    }

    /**
     * @param Brick $brickObject
     *
     * @return mixed
     */
    public static function getBrickTemplatesBasePath($brickObject)
    {

        return apply_filters('fewbricks/templater/brick_templates_base_path', false, $brickObject);

    }

    /**
     * @return mixed
     */
    public static function getViewFilesNameStructure()
    {

        return apply_filters('fewbricks/templater/brick_views_file_name_structure', '.view');

    }

}
