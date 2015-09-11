<?php

/**
 * Use this class to add project specific brick stuff. This is to avoid having the brick class polluted with
 * irrelevant stuff and make it easier to identify neat new stuff that may be re-used for other projects.
 */

namespace fewbricks\bricks;

/**
 * Class project_brick
 * @package fewbricks\bricks
 */
class project_brick extends brick
{

    /**
     * @var bool
     */
    private static $headline_tag = false;

    /**
     * @param string $name
     * @param string $key
     */
    public function __construct($name = '', $key = '')
    {

        parent::__construct($name, $key);

    }

    /**
     * Called after set_fields have been called. Use to add settings that every brick in the project should have.
     */
    public function set_project_fields()
    {

    }

    /**
     * @param $data_key
     * @param bool $value
     * @return string
     */
    protected function get_headline_html($data_key, $value = false)
    {

        $this->set_headline_tag();

        $headline = ($value !== false ? $value : $this->get_field($data_key));

        $html = '';

        if (!empty($headline)) {

            $html .= '<' . self::$headline_tag . '>' . $headline . '</' . self::$headline_tag . '>';

        }

        return $html;

    }

    /**
     *
     */
    protected function set_headline_tag()
    {

        switch (self::$headline_tag) {

            case 'h1' :

                self::$headline_tag = 'h2';
                break;

            default :

                self::$headline_tag = 'h1';

        }

    }

}