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
     * @param mixed $layout_files Array or string with the file name(s) (without .php) of any layouts that you want to
     * wrap the brick in. Use the filter fewbricks/templater/brick_layouts_base_path to change the base path of the
     * brick
     * layout files.
     * @param string|bool $template_file_path Set to a string to specify a special template file for this instance.
     */
    public function __construct(Brick $brick, array $settings = [], array $layout_files = [],
                                $template_file_path = false)
    {

        $this->brick = $brick;

        parent::__construct($settings, $layout_files, $template_file_path);

    }

    /**
     * Returns HTML for the brick wrapped in any layouts that have been specified for the brick. Acts as a wrapper
     * for getLayoutedHtml()
     *
     * @return string
     */
    public function getHtml()
    {

        return $this->getLayoutedHtml($this->getBrickHtml());

    }

    /**
     * Executes a template file for the current class and returns the output.
     *
     * @return string
     */
    private function getBrickHtml()
    {

        $template_file_path = $this->template_file_path;

        // If no brick template has been specified directly on this instance of BrickTemplater
        if (empty($template_file_path)) {

            $brick_templates_base_path = Helper::getBrickTemplatesBasePath($this->brick);

            if ($brick_templates_base_path !== false) {

                $template_file_path = $brick_templates_base_path . '/' . Helper::getBrickTemplateFileName($this->brick);

            } else {

                wp_die('Please make sure that you have used the filter <code>fewbricks/templater/brick_templates_base_path</code>
to tell Brick::getBrickTemplateHtml() where to look for brick template files.');

            }

        }

        // Data to be used in template
        $data = $this->brick->getViewData();
        $brick = $this->brick;
        $settings = $this->settings;

        ob_start();

        /** @noinspection PhpIncludeInspection */
        include $template_file_path;

        return ob_get_clean();

    }

    /**
     * @param $html
     * @return false|string
     */
    protected function getLayoutedHtml($html) {

        if (
            false !== ($layouts_base_path = Helper::getBrickLayoutsBasePath()) &&
            !empty($this->layout_files)
        ) {

            // Data to pass to the layout file
            $brick = $this->brick;
            $settings = $this->settings;

            foreach ($this->layout_files AS $layout) {

                ob_start();

                /** @noinspection PhpIncludeInspection */
                include $layouts_base_path . '/' . $layout . Helper::getViewFilesNameStructure() . '.php';

                $html = ob_get_clean();

            }

        }

        return $html;

    }

}
