<?php

/**
 * This is the file that should start your custom implementation of Fewbricks
 */

/**
 * Autoloader specific for Fewbricks in your project.
 * The idea to support subfolders comes from
 * https://github.com/macherjek1/mj-fewbricks/commit/913be9ea17
 * This function is defined here and not in the Fewbricks core files  for you to be able to
 * edit it to match it to your preferred way of naming classes and for you to be able to
 * change the location of files and namespaces.
 * Feel free to modify or delete the function as you see fit.
 * The function assumes that you are using the namespace App\Fewbricks.
 */
spl_autoload_register(function ($class) {

    $namespace_parts = explode('\\', $class);

    // Make sure that we are dealing with something in our own namesoace
    if (count($namespace_parts) > 2
        && $namespace_parts[0] === 'App'
        && $namespace_parts[1] === 'Fewbricks'
    ) {

        $file_name = end($namespace_parts) . '.php';

        // Start with our base path. Using the helper function will take into account
        // any filters used to modify the base path.
        $path = \Fewbricks\Helpers::get_project_files_base_path() . '/';

        // If there is more than App\Fewbricks\Bricks\BrickName.php
        if (count($namespace_parts) > 3) {

            $path .= implode('/', array_slice($namespace_parts, 2, -1)) . '/';

        }

        $path .= $file_name;

        // Yes, by not checking of the file exists, we do get ugly error messages.
        // But we save some execution time by not checking if the file exists first.
        include($path);

    }

});

