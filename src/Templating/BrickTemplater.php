<?php

namespace Fewbricks\Templating;

use Fewbricks\Brick;

class BrickTemplater extends Templater
{

    /**
     * @var Brick
     */
    protected $brick;

    /**
     * @param Brick $brick An instance of the brick that you want to create HTML for.
     * @param array $settings Any arguments that you need to pass to the brick on runtime. Available as
     * $this->getHtmlArguments
     * @param mixed $layoutFiles Array or string with the file name(s) (without .php) of any layouts that you want to
     * wrap the brick in. Use the filter fewbricks/templater/brick_layouts_base_path to change the base path of the
     * brick
     * layout files.
     * @param string|bool $templateFilePath Set to a string to specify a special template file for this instance.
     */
    public function __construct($brick, array $settings = [], array $layoutFiles = [], $templateFilePath = false)
    {

        $this->brick = $brick;

        parent::__construct($settings, $layoutFiles, $templateFilePath);

    }

    /**
     * Returns HTML for the brick wrapped in any layouts that have been specified for the brick. Acts as a wrapper
     * for get_layouted_html()
     *
     * @return string
     */
    public function get_html()
    {

        return $this->get_layouted_html($this->get_brick_html());

    }

    /**
     * Executes a template file for the current class and returns the output.
     *
     * @return string
     */
    private function get_brick_html()
    {

        $templateFilePath = $this->templateFilePath;

        // If no brick template has been specified directly on this instance of BrickTemplater
        if (empty($templateFilePath)) {

            $brickTemplatesBasePath = Helper::get_brick_templates_base_path($this->brick);

            if ($brickTemplatesBasePath !== false) {

                $templateFilePath = $brickTemplatesBasePath . '/' . Helper::get_brick_template_file_name($this->brick);

            } else {

                \Fewbricks\Helpers\Helper::fewbricks_die(('Please make sure that you have used the filter <code>fewbricks/templater/brick_templates_base_path</code>
to tell Brick::getBrickTemplateHtml() where to look for brick template files.'));

            }

        }

        // Data to be used in template
        $data = $this->brick->get_view_data();
        $brick = $this->brick;
        $settings = $this->settings;

        ob_start();

        /** @noinspection PhpIncludeInspection */
        include $templateFilePath;

        return ob_get_clean();

    }

    /**
     * @param $html
     * @return false|string
     */
    protected function get_layouted_html(string $html) {

        if (
            false !== ($layoutsBasePath = Helper::get_brick_layouts_base_path()) &&
            !empty($this->layoutFiles)
        ) {

            // Data to pass to the layout file
            $brick = $this->brick;
            $settings = $this->settings;

            foreach ($this->layoutFiles AS $layout) {

                ob_start();

                /** @noinspection PhpIncludeInspection */
                include $layoutsBasePath . '/' . $layout . Helper::get_view_files_name_structure() . '.php';

                $html = ob_get_clean();

            }

        }

        return $html;

    }

}
