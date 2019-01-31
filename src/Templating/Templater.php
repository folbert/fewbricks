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
    protected $templateFilePath;

    /**
     * @var array Settings to be passed to the template and all layouts
     */
    protected $settings;

    /**
     * @var
     */
    protected $layoutFiles;

    /**
     * Templater constructor.
     * @param array $getHtmlArguments
     * @param array $layoutFiles
     * @param string $templateFilePath
     */
    public function __construct(array $getHtmlArguments, array $layoutFiles, string $templateFilePath)
    {

        $this->templateFilePath = $templateFilePath;
        $this->addSettings($getHtmlArguments);
        $this->addLayouts($layoutFiles);

    }

    /**
     * Add a single layout to the brick. String with the name of the layout (without .php).
     * Use the filter fewbricks/templater/brick_layouts_base_path to set the path to the layout file.
     *
     * @param string $layoutFileName
     * @return $this
     */
    public function addLayout($layoutFileName)
    {

        $this->layoutFiles[$layoutFileName] = $layoutFileName;

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
     * @param mixed $defaultValue Value to return if the settings has not been set
     *
     * @return bool
     */
    public function get_settings($name, $defaultValue = false)
    {

        if (isset($this->settings[$name])) {

            $outcome = $this->settings[$name];

        } else {

            $outcome = $defaultValue;

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

        foreach ($settings AS $settingsName => $settingsValue) {
            $this->addSetting($settingsName, $settingsValue);
        }

        return $this;

    }

}
