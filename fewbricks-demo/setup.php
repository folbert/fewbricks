<?php

namespace FewbricksDemo;

/**
 * Check the documentation for info on filters
 */

add_filter('fewbricks/dev_mode/enable', '__return_true');

add_filter('fewbricks/show_fields_info', '__return_true');

add_filter('fewbricks/info_pane/display', function () {
    return true;
});

add_filter('fewbricks/info_pane/acf_arrays/display_all', function () {
    return false;
});

add_filter('fewbricks/exporter/php/auto_write_target', function () {
    return false;
    //return Helper::getFewbricksInstallPath() . '/gitignored/fewbricks-php.php';
});

add_filter('fewbricks/exporter/display_php_file_written_message', '__return_true');

/**
 * Simple autoloader
 */
spl_autoload_register(function ($class) {

    $classNamespaceParts = explode('\\', $class);

    // Make sure we are dealing with our namespace
    if (substr($class, 0, strlen(__NAMESPACE__)) === __NAMESPACE__) {

        $path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR;
        $path .= implode(DIRECTORY_SEPARATOR, array_slice($classNamespaceParts, 1)) . '.php';

        /** @noinspection PhpIncludeInspection */
        include $path;

    }

});
