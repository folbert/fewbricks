<?php

namespace fewbricks\bricks;

use fewbricks\acf\fields as acf_fields;

/**
 * Class text_and_content
 * @package fewbricks\bricks
 */
class demo_jumbotron extends project_brick
{

    /**
     * @var string This will be the default label showing up in the editor area for the administrator.
     * It can be overridden by passing an item with the key "label" in the array that is the second argument when
     * creating a brick.
     */
    protected $label = 'Demo Jumbotron';

    /**
     * This is where all the fields for the brick will be set-
     */
    public function set_fields()
    {

        $this->add_field(new acf_fields\text('Headline', 'headline', '1603242311a'));
        
        $this->add_field(new acf_fields\textarea('Text', 'text', '1603242313a'));

        $this->add_brick((new demo_button('button', '1603242312a'))->set_field_label_prefix('Button'));

    }

    /**
     * @return string|void
     */
    public function get_brick_html()
    {

        return $this->get_brick_template_html();

    }

}