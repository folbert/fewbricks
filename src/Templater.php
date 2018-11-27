<?php

namespace Fewbricks;

class Templater
{

    /**
     * Executes a template file for the current class and returns the output.
     *
     * @param $brick Instance of the brick to create html for
     * @param array $data Array of data to pass to the template file
     * @param bool|string $template_file_path If you want to set a specific base path, pass it here. End with a slash.
     *
     * @return string
     */
    public static function getBrickHtml($brick, array $data = [], $template_file_path = false)
    {

        if ($template_file_path === false) {

            $brick_templates_base_path = Helper::getBrickTemplatesBasePath($brick);

            if ($brick_templates_base_path !== false) {

                $template_file_path = $brick_templates_base_path . '/' . Helper::getBrickTemplateFileName($brick);

            } else {

                wp_die(__('Please make sure that you have used the filter <code>fewbricks/bricks/templates_base_path</code>
to tell Brick::getBrickTemplateHtml() where to look for brick template files.', 'fewbricks'));

            }

        }

        ob_start();

        /** @noinspection PhpIncludeInspection */
        include($template_file_path);

        return ob_get_clean();

    }

}
