<?php

namespace fewbricks\bricks;

use fewbricks\acf\fields as acf_fields;

/**
 * Class text_and_content
 * @package fewbricks\bricks
 */
class demo_headline extends project_brick
{

    /**
     * @var string This will be the default label showing up in the editor area for the administrator.
     * It can be overridden by passing an item with the key "label" in the array that is the second argument when
     * creating a brick.
     */
    protected $label = 'Demo Headline';

    /**
     * This is where all the fields for the brick will be set-
     */
    public function set_fields()
    {

        $this->add_field(new acf_fields\text('Text', 'text', '16032500045a'));

        $this->add_field(new acf_fields\select('Headline level', 'level', '1603250045b', [
            'choices' => [
                '1' => 1,
                '2' => 2,
                '3' => 3,
                '4' => 4,
                '5' => 5,
                '6' => 6
            ],
            'default_value' => 1,
            'allow_null' => 0
        ]));

    }

    /**
     * @return string|void
     */
    public function get_brick_html()
    {

        $level = $this->get_field('level');

        return '<h' . $level . '>' . $this->get_field('text') . '</h' . $level . '>';

    }

}