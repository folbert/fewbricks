<?php

//namespace App\Fewbricks;
namespace Fewbricks\Demo;

/**
 * Class Filters
 *
 * @package Fewbricks\Demo
 */
class Filters
{

    /**
     *
     */
    public static function define_hooks()
    {

        add_filter('fewbricks/project_files_base_path',
            [__NAMESPACE__ . '\\Fewbricks', 'getProjectFilesBasePath']);

        add_filter('fewbricks/brick/brick_layout_base_path',
            [__NAMESPACE__ . '\\Fewbricks', 'getLayoutBasePath']);

        add_filter('fewbricks/brick/brick_template_base_path',
            [__NAMESPACE__ . '\\Fewbricks', 'getBrickTemplateBasePath']);

        add_filter('fewbricks/brick/brick_template_file_extension',
            [__NAMESPACE__ . '\\Fewbricks', 'getTemplateFileExtension']);

        add_action('admin_notices',
            [__NAMESPACE__ . '\\Fewbricks', 'editFieldGroupInfo']);

        add_filter('fewbricks/show_fields_info', '__return_true');

    }

    /**
     * @return string
     */
    public static function getBrickTemplatesBasePath()
    {

        return get_stylesheet_directory() . '/fewbricks/bricks/';

    }

    /**
     * @return string
     */
    public static function getLayoutBasePath()
    {

        return get_template_directory() . '/templates/module-layouts';

    }

    /**
     * @return string
     */
    public static function getProjectFilesBasePath()
    {

        //return get_template_directory() . '/fewbrick2';
        return WP_PLUGIN_DIR . '/fewbricks/fewbricks';

    }

    /**
     * @return string
     */
    public static function get_template_file_extension()
    {

        return '.view.php';

    }

    /**
     *
     */
    public static function editFieldGroupInfo()
    {

        if (get_current_screen()->post_type === 'acf-field-group') {

            $message_html
                = '
                <div class="notice notice-info">
                    <p>If you are looking for field groups that you know should be here, please note that we are using <a href="https://github.com/folbert/fewbricks" target="_blank">Fewbricks</a> to create ACF-fields.</p>
                </div>';

            echo $message_html;

        }

    }

}
