<?php

/**
 * Demoing available filters
 */

namespace App\FewbricksDemo;

/**
 * Class FiltersApplier
 *
 * @package App\FewbricksDemo
 */
class FiltersApplier
{

    /**
     *
     */
    public static function defineHooks()
    {

        // In a real project, this particular filter would have to be added outside the Fewbricks folder.
        // Like for example in functions.php
        /*add_filter('fewbricks/project_files_base_path',
            [$me . '\\Fewbricks', 'getProjectFilesBasePath']);*/

        add_filter('fewbricks/brick/brick_layouts_base_path',
            [self::class, 'getBrickLayoutsBasePath']);

        add_filter('fewbricks/brick_templates_base_path', [self::class, 'getBrickTemplatesBasePath'], 10, 2);

        // Not used but added for demo puprposes
        //add_filter('fewbricks/brick_template_file_name', [self::class, 'getBrickTemplateFileName'], 10, 2);

        add_filter('fewbricks/exporter/auto_write_php_code_file', [self::class, 'getPhpCodeFilePath']);
        add_filter('fewbricks/exporter/display_php_file_written_message', '__return_false');

        add_filter('fewbricks/dev_tools/show_fields_info', '__return_true');

        add_action('admin_notices', [self::class, 'editFieldGroupInfo']);

    }

    /**
     *
     */
    public static function editFieldGroupInfo()
    {

        if (get_current_screen()->post_type === 'edit-acf-field-group') {

            $message_html
                = '
                <div class="notice notice-info">
                    <p>If you are looking for field groups that you know should be here, please note that we are using <a href="https://github.com/folbert/fewbricks" target="_blank">Fewbricks</a> to create ACF-fields.</p>
                </div>';

            echo $message_html;

        }

    }

    /**
     * @param $brickInstance
     *
     * @return string
     */
    public static function getBrickTemplatesBasePath($brickTemplatesBasePath, $brickInstance)
    {

        return FEWBRICKS_PROJECT_FILES_BASE_PATH . '/lib/Bricks/';

    }

    /**
     * @return string
     */
    public static function getBricksLayoutsBasePath()
    {

        return get_template_directory() . '/templates/brick-layouts';

    }

    /**
     * @return string
     */
    public static function getPhpCodeFilePath()
    {

        return WP_PLUGIN_DIR . '/fewbricks/gitignored/fewbricks-php.php';

    }

    /**
     * @return string
     */
    public static function getProjectFilesBasePath()
    {

        return FEWBRICKS_PROJECT_FILES_BASE_PATH;

    }

    /**
     * @return string
     */
    public static function getTemplateFileExtension()
    {

        return '.view.php';

    }

    /**
     * @param string $fileName
     * @param object $brickInstance
     *
     * @return string
     */
    public static function getBrickTemplateFileName($fileName, $brickInstance)
    {

        return $fileName;

    }

}
