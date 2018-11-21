<?php

/**
 * Code related to setting up the Fewbricks demo
 */

namespace App\FewbricksDemo;

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
use Fewbricks\Helper;

require __DIR__ . '/fewbricks-demo-custom-post-types.php';

spl_autoload_register(function ($class) {

    $namespaceStart = 'App\FewbricksDemo';

    $namespaceParts = explode('\\', $class);

    if(substr($class, 0, strlen($namespaceStart)) === $namespaceStart) {

        $fileName = end($namespaceParts) . '.php';

        // Using the helper function will take into account any filters used to modify the base path.
        $path = Helper::getProjectFilesBasePath() . '/lib/';

        // If there is more than App\FewbricksDemo\Bricks\BrickName.php...
        if (count($namespaceParts) > 3) {

            // ...use the namespaces but remove App/FewbricksDemo and also the last part (the filename) since we will
            // append that later.
            $path .= implode('/', array_slice($namespaceParts, 2, -1)) . '/';

        }

        $path .= $fileName;

        // In a production environment i would probably go without this check to speed things up a bit
        // but since this is a test/dev environment, lets do it like this.
        if (file_exists($path)) {

            /** @noinspection PhpIncludeInspection */
            include $path;

        } else {

            wp_die('Fewbricks could not locate the class ' . $class);

        }

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

add_filter('template_include', __NAMESPACE__ . '\\templateInclude', 99);
