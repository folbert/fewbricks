<?php

/**
 * Code related to setting up the Fewbricks demo
 */

namespace Fewbricks\Demo;

/**
 * Autoloader specific for Fewbricks in your project.
 * The idea to support sub folders comes from https://github.com/macherjek1/mj-fewbricks/commit/913be9ea17
 * This function is defined here and not in the Fewbricks core files in order for you to be able to edit it to match
 * it to your preferred way of naming classes and for you to be able to change the location of files and namespaces.
 * Or remove it completely and require files as you see fit or use Composer.
 * Or do it any other way that you prefer.
 * Feel free to modify or delete the function as you see fit.
 * The function assumes that you are using the namespace App\FewbricksDemo.
 */

//require __DIR__ . '/fewbricks-demo-custom-post-types.php';

spl_autoload_register(function ($class) {

    $class_namespace_parts = explode('\\', $class);

    // Make sure we are dealing with our namespace
    if (substr($class, 0, strlen(__NAMESPACE__)) === __NAMESPACE__) {

        $path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR;

        // If there is more  than Fewbricks\Demo\Bricks\BrickName.php...
        //if (count($class_namespace_parts) > 3) {

            // ...use the namespaces but remove App/FewbricksDemo and also the last part (the filename) since we will
            // append that later.
            $path .= implode(DIRECTORY_SEPARATOR, array_slice($class_namespace_parts, 2, -1)) . DIRECTORY_SEPARATOR;

        //}

        $path .= end($class_namespace_parts) . '.php';
        
        /** @noinspection PhpIncludeInspection */
        include $path;

    }

});

// Force demo pages to use our demo templates
function templateInclude($template)
{

    if (get_post_type() === 'fewbricks_demo_pg' or get_post_type() === 'fewbricks_demo_pg2') {

        $template = __DIR__ . '/templates/pages/demo-page-template.php';
    }

    return $template;
}

//add_filter('template_include', __NAMESPACE__ . '\\templateInclude', 99);
