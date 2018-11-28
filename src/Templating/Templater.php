<?php

namespace Fewbricks\Templating;

/**
 * Simple templating system to quickly get up and running with Fewbricks
 *
 * Class Templater
 * @package Fewbricks\Templating
 */
class Templater
{

    /**
     * @var string|bool
     */
    protected $template_file_path;

    /**
     * @var array Settings to be passed to the template and all layouts
     */
    protected $settings;

    /**
     * @var
     */
    protected $layout_files;

    /**
     * Templater constructor.
     * @param array $get_html_arguments
     * @param array $layout_files
     * @param string $template_file_path
     */
    public function __construct(array $get_html_arguments, array $layout_files, $template_file_path)
    {

        $this->template_file_path = $template_file_path;
        $this->addSettings($get_html_arguments);
        $this->addLayouts($layout_files);

    }

    /**
     * Add a single layout to the brick. String with the name of the layout (without .php).
     * Use the filter fewbricks/templater/brick_layouts_base_path to set the path to the layout file.
     *
     * @param string $layout_file_name
     * @return $this
     */
    public function addLayout($layout_file_name)
    {

        $this->layout_files[$layout_file_name] = $layout_file_name;

        return $this;

    }

    /**
     * @param string|array $layouts Array or string with the name of the layout(s) (without .php).
     * Use the filter
     * @return $this
     */
    public function addLayouts($layouts)
    {

        if (is_string($layouts)) {

            $this->addLayout($layouts);

        } else if (is_array($layouts)) {

            foreach ($layouts AS $layout) {

                $this->addLayout($layout);

            }

        }

        return $this;

    }

    /**
     * Get a value from previously sent "get HTML argument".
     *
     * @param string $name
     * @param mixed $default_value Value to return if the settings has not been set
     *
     * @return bool
     */
    public function getSettings($name, $default_value = false)
    {

        if (isset($this->settings[$name])) {

            $outcome = $this->settings[$name];

        } else {

            $outcome = $default_value;

        }

        return $outcome;

    }

    /**
     * Store a settings with value of $value that can later be accessed using $name.
     * @param string $name
     * @param mixed $value
     * @return $this
     */
    public function addSetting(string $name, $value)
    {

        $this->settings[$name] = $value;

        return $this;

    }

    /**
     * Takes an associative array where the index will be the names that the corresponding value will be stored as.
     * @param array $settings
     * @return Templater
     */
    public function addSettings(array $settings)
    {

        foreach ($settings AS $settings_name => $settings_value) {
            $this->addSetting($settings_name, $settings_value);
        }

        return $this;

    }

}
