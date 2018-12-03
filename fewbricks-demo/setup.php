<?php

namespace FewbricksDemo;

/**
 * Check the documentation for info on filters
 */

add_filter('fewbricks/dev_tools/show_fields_info', '__return_true');

add_filter('fewbricks/templater/brick_templates_base_path', function () {
    return __DIR__ . '/views/brick-templates';
});

add_filter('fewbricks/templater/brick_layouts_base_path', function () {
    return __DIR__ . '/views/brick-layouts';
});

add_filter('fewbricks/dev_tools/display', function () {
    return true;
});

add_filter('fewbricks/dev_tools/acf_arrays/keys', function () {
    return false;
});

add_filter('fewbricks/exporter/auto_write_php_code_file', function () {
    return false;
    //return Helper::getFewbricksInstallPath() . '/gitignored/fewbricks-php.php';
});

add_filter('fewbricks/exporter/display_php_file_written_message', '__return_true');

/**
 * Simple autoloader
 */
spl_autoload_register(function ($class) {

    $class_namespace_parts = explode('\\', $class);

    // Make sure we are dealing with our namespace
    if (substr($class, 0, strlen(__NAMESPACE__)) === __NAMESPACE__) {

        $path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR;
        $path .= implode(DIRECTORY_SEPARATOR, array_slice($class_namespace_parts, 1)) . '.php';

        /** @noinspection PhpIncludeInspection */
        include $path;

    }

});
